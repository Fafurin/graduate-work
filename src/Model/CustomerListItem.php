<?php

namespace App\Model;

class CustomerListItem
{
    /**
     * @param int $id
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $contactPerson
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $phone,
        private string $email,
        private string $contactPerson)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getContactPerson(): string
    {
        return $this->contactPerson;
    }
}
