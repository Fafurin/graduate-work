<?php

namespace App\Repositories\User\Position;

use App\Entities\EntityInterface;
use App\Entities\User\Position\Position;
use App\Exceptions\PositionNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class PositionRepository extends EntityRepository implements PositionRepositoryInterface
{

    /**
     * @throws PositionNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM positions WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getPosition($statement);
    }

    /**
     * @throws PositionNotFoundException
     */
    private function getPosition(\PDOStatement $statement): Position
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (false === $result) {
            throw new PositionNotFoundException("Position not found");
        }

        return new Position($result['title']);
    }

    /**
     * @throws PositionNotFoundException
     */
    public function getPositionByTitle(string $title): Position
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM positions WHERE title = :title'
        );

        $statement->execute([':title' => $title]);

        return $this->getPosition($statement);
    }
}