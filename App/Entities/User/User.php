<?php

namespace App\Entities\User;

use App\Traits\Id;

class User implements UserInterface
{

    use Id;

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $middleName,
        public string $phone,
        public string $email,
    )
    {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}