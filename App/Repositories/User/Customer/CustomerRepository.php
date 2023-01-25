<?php

namespace App\Repositories\User\Customer;

use App\Entities\EntityInterface;
use App\Entities\User\Customer\Customer;
use App\Exceptions\CustomerNotFoundException;
use App\Repositories\EntityRepository;
use PDO;
use PDOStatement;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{

    /**
     * @throws CustomerNotFoundException
     */
    public function get(int $id): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM customers WHERE id = :id'
        );

        $statement->execute([':id' => $id]);

        return $this->getCustomer($statement);
    }

    /**
     * @throws CustomerNotFoundException
     */
    private function getCustomer(PDOStatement $statement): Customer
    {
        $result = $statement->fetch(PDO::FETCH_OBJ);
        if (!$result) {
            throw new CustomerNotFoundException("Customer not found");
        }

        return new Customer(
            $result->first_name,
            $result->last_name,
            $result->middle_name,
            $result->phone,
            $result->email
        );
    }

    /**
     * @throws CustomerNotFoundException
     */
    public function getCustomerByEmail(string $email): EntityInterface
    {
        $statement = $this->connector->getConnection()->prepare(
            'SELECT * FROM customers WHERE email = :email'
        );

        $statement->execute([':email' => $email]);

        return $this->getCustomer($statement);
    }

}