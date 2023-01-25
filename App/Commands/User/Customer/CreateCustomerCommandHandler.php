<?php

namespace App\Commands\User\Customer;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\User\Customer\Customer;
use App\Exceptions\UserEmailExistException;
use App\Exceptions\CustomerNotFoundException;
use App\Repositories\User\Customer\CustomerRepository;
use App\Repositories\User\Customer\CustomerRepositoryInterface;

class CreateCustomerCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?CustomerRepositoryInterface $customerRepository = null,
        private ?ConnectorInterface $connector = null
    ){
        $this->customerRepository = $customerRepository ?? new CustomerRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }


    /**
     * @throws UserEmailExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Customer $customer
         */
        $customer = $command->getEntity();
        $email = $customer->getEmail();

        if(!$this->isCustomerExists($email)) {
            $this->statement->execute([
                ':first_name' => $customer->getFirstName(),
                ':last_name' => $customer->getLastName(),
                ':middle_name' => $customer->getMiddleName(),
                ':phone' => $customer->getPhone(),
                ':email' => $customer->getEmail(),
            ]);
        } else {
            throw new UserEmailExistException();
        }
    }

    public function isCustomerExists(string $email): bool
    {
        try {
            $this->customerRepository->getCustomerByEmail($email);
        } catch (CustomerNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSql(): string
    {
        return "INSERT INTO customers (first_name, last_name, middle_name, phone, email) 
                             VALUES (:first_name, :last_name, :middle_name, :phone, :email)";
    }

}