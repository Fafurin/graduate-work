<?php

namespace App\Entities\User\Employee;

use App\Entities\User\User;
use App\Traits\Id;

class Employee extends User implements EmployeeInterface
{

    use Id;

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $middleName,
        public string $phone,
        public string $email,
        public string $address,
        public string $birthday,
        public string $startedAt,
        public int $positionId,
        public int $roleId
    )
    {}

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getStartedAt(): string
    {
        return $this->startedAt;
    }

    public function getPositionId(): string
    {
        return $this->positionId;
    }

    public function getRoleId(): string
    {
        return $this->roleId;
    }

}