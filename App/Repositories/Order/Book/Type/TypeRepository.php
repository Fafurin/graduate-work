<?php

namespace App\Repositories\Order\Book\Type;

use App\Entities\EntityInterface;
use App\Entities\Order\Book\Type\Type;
use App\Exceptions\TypeNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class TypeRepository extends EntityRepository implements TypeRepositoryInterface
{
    /**
     * @throws TypeNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM types WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getType($statement);
    }

    /**
     * @throws TypeNotFoundException
     */
    private function getType(\PDOStatement $statement): Type
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new TypeNotFoundException("Type not found");
        }
        return new Type($result->title);
    }

    /**
     * @throws TypeNotFoundException
     */
    public function getTypeByTitle(string $title): Type
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM types WHERE title = :title'
        );
        $statement->execute([':title' => $title]);

        return $this->getType($statement);
    }
}