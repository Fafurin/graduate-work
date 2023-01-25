<?php

namespace App\Commands\Task;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\Task\Task;

class CreateTaskCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(private ?ConnectorInterface $connector = null)
    {
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    public function handle(CommandInterface $command): void
    {
        /**
         * @var Task $task
         */

        $task = $command->getEntity();

        $this->statement->execute([
            ':title' => $task->getTitle(),
            ':employee_id' => $task->getEmployeeId(),
            ':order_id' => $task->getOrderId(),
            ':status_id' => $task->getStatusId(),
            ':started_date' => $task->getStartedDate(),
            ':finished_date' => $task->getFinishedDate(),
        ]);
    }

    public function getSQL(): string
    {
        return "INSERT INTO tasks (title, employee_id, order_id, 
                                   status_id, started_date, finished_date) 
                           VALUES (:title, :employee_id, :order_id, 
                                   :status_id, :started_date, :finished_date)";
    }
}