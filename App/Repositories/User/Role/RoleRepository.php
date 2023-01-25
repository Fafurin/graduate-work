<?php

namespace App\Repositories\User\Role;

use App\Entities\EntityInterface;
use App\Entities\User\Role\Role;
use App\Exceptions\RoleNotFoundException;
use App\Repositories\EntityRepository;
use PDO;

class RoleRepository extends EntityRepository implements RoleRepositoryInterface
{
    /**
     * @throws RoleNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM roles WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getRole($statement);
    }

    /**
     * @throws RoleNotFoundException
     */
    private function getRole(\PDOStatement $statement): Role
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new RoleNotFoundException("Role not found");
        }

        return new Role($result->title);
    }

    /**
     * @throws RoleNotFoundException
     */
    public function getRoleByTitle(string $title): Role
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM roles WHERE title = :title'
        );

        $statement->execute([':title' => $title]);

        return $this->getRole($statement);
    }
}