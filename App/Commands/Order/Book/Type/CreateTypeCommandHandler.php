<?php

namespace App\Commands\Order\Book\Type;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Book\Type\Type;
use App\Exceptions\TypeNotFoundException;
use App\Exceptions\TypeTitleExistException;
use App\Repositories\Order\Book\Type\TypeRepository;
use App\Repositories\Order\Book\Type\TypeRepositoryInterface;

class CreateTypeCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?TypeRepositoryInterface $typeRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->typeRepository = $typeRepository ?? new TypeRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws TypeTitleExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Type $type
         */

        $type = $command->getEntity();
        $title = $type->getTitle();

        if (!$this->isTypeExists($title)) {
            $this->statement->execute([':title' => $title]);
        } else throw new TypeTitleExistException();
    }

    private function isTypeExists(string $title): bool
    {
        try {
            $this->typeRepository->getTypeByTitle($title);
        } catch (TypeNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO types (title) VALUES (:title)";
    }
}