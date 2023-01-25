<?php

namespace App\Repositories\User\Employee;

use App\Entities\EntityInterface;
use App\Entities\User\Employee\Employee;
use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\EntityRepository;
use PDO;
use PDOStatement;

class EmployeeRepository extends EntityRepository implements EmployeeRepositoryInterface
{

    /**
     * @throws EmployeeNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM employees WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getEmployee($statement);
    }

    /**
     * @throws EmployeeNotFoundException
     */
    private function getEmployee(PDOStatement $statement): Employee
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new EmployeeNotFoundException("Employee not found");
        }
        return new Employee(
            $result->first_name,
            $result->last_name,
            $result->middle_name,
            $result->phone,
            $result->email,
            $result->address,
            $result->birthday,
            $result->started_at,
            $result->position_id,
            $result->role_id,
        );
    }

    /**
     * @throws EmployeeNotFoundException
     */
    public function getEmployeeByEmail(string $email): Employee
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM employees WHERE email = :email'
        );

        $statement->execute([':email' => $email]);

        return $this->getEmployee($statement);
    }
}