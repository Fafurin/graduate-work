<?php

namespace App\Commands\User\Employee;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\User\Employee\Employee;
use App\Exceptions\UserEmailExistException;
use App\Exceptions\EmployeeNotFoundException;
use App\Repositories\User\Employee\EmployeeRepository;
use App\Repositories\User\Employee\EmployeeRepositoryInterface;

class CreateEmployeeCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?EmployeeRepositoryInterface $employeeRepository = null,
        private ?ConnectorInterface $connector = null
    ){
        $this->employeeRepository = $employeeRepository ?? new EmployeeRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }


    /**
     * @throws UserEmailExistException
     */
    public function handle(CommandInterface $command): void
    {


        /**
         * @var Employee $employee
         */
        $employee = $command->getEntity();
        $email = $employee->getEmail();

        if(!$this->isEmployeeExists($email)) {
            $this->statement->execute([
                ':first_name' => $employee->getFirstName(),
                ':last_name' => $employee->getLastName(),
                ':middle_name' => $employee->getMiddleName(),
                ':phone' => $employee->getPhone(),
                ':email' => $employee->getEmail(),
                ':address' => $employee->getAddress(),
                ':birthday' => $employee->getBirthday(),
                ':started_at' => $employee->getStartedAt(),
                ':position_id' => $employee->getPositionId(),
                ':role_id' => $employee->getRoleId(),
            ]);
        } else {
            throw new UserEmailExistException();
        }
    }

    public function isEmployeeExists(string $email): bool
    {
        try {
            $this->employeeRepository->getEmployeeByEmail($email);
        } catch (EmployeeNotFoundException) {
            return false;
        }
        return true;
    }

    public function getSql(): string
    {
        return "INSERT INTO employees (first_name, last_name, middle_name, phone, email, 
                       address, birthday, started_at, position_id, role_id)
                       VALUES (:first_name, :last_name, :middle_name, :phone, :email, 
                               :address, :birthday, :started_at, :position_id, :role_id)";
    }

}