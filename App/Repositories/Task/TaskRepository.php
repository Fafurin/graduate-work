<?php

namespace App\Repositories\Task;

use App\Entities\EntityInterface;
use App\Entities\Task\Task;
use App\Exceptions\TaskNotFoundException;
use App\Repositories\EntityRepository;
use PDO;
use PDOStatement;

class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{

    /**
     * @throws TaskNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM tasks WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getTask($statement);
    }

    /**
     * @throws TaskNotFoundException
     */
    private function getTask(PDOStatement $statement): Task
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new TaskNotFoundException("Task not found");
        }

        return new Task(
            $result->title,
            $result->employee_id,
            $result->order_id,
            $result->status_id,
            $result->started_date,
            $result->finished_date
        );
    }
}