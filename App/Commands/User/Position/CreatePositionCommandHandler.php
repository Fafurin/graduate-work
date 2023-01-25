<?php

namespace App\Commands\User\Position;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\User\Position\Position;
use App\Exceptions\PositionNotFoundException;
use App\Exceptions\PositionTitleExistException;
use App\Repositories\User\Position\PositionRepository;
use App\Repositories\User\Position\PositionRepositoryInterface;

class CreatePositionCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?PositionRepositoryInterface $positionRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->positionRepository = $positionRepository ?? new PositionRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws PositionTitleExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Position $position
         */

        $position = $command->getEntity();
        $title = $position->getTitle();

        if(!$this->isPositionExists($title)) {
            $this->statement->execute([
                ':title' => $title
            ]);
        } else {
            throw new PositionTitleExistException();
        }
    }

    private function isPositionExists(string $title): bool
    {
        try {
            $this->positionRepository->getPositionByTitle($title);
        } catch (PositionNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO positions (title) VALUES (:title)";
    }
}