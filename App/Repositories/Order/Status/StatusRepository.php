<?php

namespace App\Repositories\Order\Status;

use App\Entities\Order\Status\Status;
use App\Exceptions\StatusNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class StatusRepository extends EntityRepository implements StatusRepositoryInterface
{

    /**
     * @throws StatusNotFoundException
     */
    public function get(int $id): Status
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM statuses WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getStatus($statement);
    }

    /**
     * @throws StatusNotFoundException
     */
    private function getStatus(\PDOStatement $statement): Status
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new StatusNotFoundException("Status not found");
        }
        return new Status($result->title);
    }

    /**
     * @throws StatusNotFoundException
     */
    public function getStatusByTitle(string $title): Status
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM statuses WHERE title = :title'
        );
        $statement->execute([':title' => $title]);

        return $this->getStatus($statement);
    }

}