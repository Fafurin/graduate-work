<?php

namespace App\Entities\Order;

use App\Traits\Id;

class Order implements OrderInterface
{
    use Id;

    public function __construct(
        private ?int $number = null,
        private int $customerId,
        private int $bookId,
        private ?string $payment = null,
        private ?string $deadline = null,
        private int $statusId,
        private string $acceptedDate,
        private ?string $startedDate = null,
        private ?string $finishedDate = null,
        private ?string $description = null,
    )
    {}

    public function getNumber(): int|null
    {
        return $this->number;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getBookId(): int
    {
        return $this->bookId;
    }

    public function getPayment(): string|null
    {
        return $this->payment;
    }

    public function getDeadline(): string|null
    {
        return $this->deadline;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function getAcceptedDate(): string
    {
        return $this->acceptedDate;
    }

    public function getStartedDate(): string|null
    {
        return $this->startedDate;
    }

    public function getFinishedDate(): string|null
    {
        return $this->finishedDate;
    }

    public function getDescriptions(): string|null
    {
        return $this->description;
    }
}