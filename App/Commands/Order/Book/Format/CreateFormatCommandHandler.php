<?php

namespace App\Commands\Order\Book\Format;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Book\Format\Format;
use App\Exceptions\FormatNotFoundException;
use App\Exceptions\FormatTitleExistException;
use App\Repositories\Order\Book\Format\FormatRepository;
use App\Repositories\Order\Book\Format\FormatRepositoryInterface;

class CreateFormatCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?FormatRepositoryInterface $formatRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->formatRepository = $formatRepository ?? new FormatRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws FormatTitleExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Format $format
         */

        $format = $command->getEntity();
        $title = $format->getTitle();

        if (!$this->isFormatExists($title)) {
            $this->statement->execute([
                ':title' => $title,
                ':size' => $format->getSize()
            ]);
        } else throw new FormatTitleExistException();
    }

    private function isFormatExists(string $title): bool
    {
        try {
            $this->formatRepository->getFormatByTitle($title);
        } catch (FormatNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO formats (title, size) VALUES (:title, :size)";
    }
}