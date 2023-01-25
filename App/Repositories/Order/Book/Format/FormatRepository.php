<?php

namespace App\Repositories\Order\Book\Format;

use App\Entities\EntityInterface;
use App\Entities\Order\Book\Format\Format;
use App\Exceptions\FormatNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class FormatRepository extends EntityRepository implements FormatRepositoryInterface
{
    /**
     * @throws FormatNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM formats WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getFormat($statement);
    }

    /**
     * @throws FormatNotFoundException
     */
    private function getFormat(\PDOStatement $statement): Format
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (false === $result) {
            throw new FormatNotFoundException("Format not found");
        }

        return new Format($result->title, $result->size);
    }

    /**
     * @throws FormatNotFoundException
     */
    public function getFormatByTitle(string $title): Format
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM formats WHERE title = :title'
        );
        $statement->execute([':title' => $title]);

        return $this->getFormat($statement);
    }
}