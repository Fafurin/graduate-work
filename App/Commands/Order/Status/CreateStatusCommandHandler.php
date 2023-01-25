<?php

namespace App\Commands\Order\Status;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Order\Status\Status;
use App\Exceptions\StatusNotFoundException;
use App\Exceptions\StatusTitleExistException;
use App\Repositories\Order\Status\StatusRepository;
use App\Repositories\Order\Status\StatusRepositoryInterface;

class CreateStatusCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?StatusRepositoryInterface $statusRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->statusRepository = $statusRepository ?? new StatusRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws StatusTitleExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Status $status
         */

        $status = $command->getEntity();
        $title = $status->getTitle();

        if (!$this->isStatusExists($title)){
            $this->statement->execute([
                ':title' => $title
            ]);
        } else throw new StatusTitleExistException();
    }

    private function isStatusExists(string $title): bool
    {
        try {
            $this->statusRepository->getStatusByTitle($title);
        } catch (StatusNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO statuses (title) VALUES (:title)";
    }
}