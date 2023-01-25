<?php

namespace App\Entities\Task;

use App\Traits\Id;
use App\Traits\Title;

class Task implements TaskInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
        private int $employeeId,
        private int $orderId,
        private int $statusId,
        private ?string $startedDate = null,
        private ?string $finishedDate = null,
    )
    {}

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function getStartedDate(): string|null
    {
        return $this->startedDate;
    }

    public function getFinishedDate(): string|null
    {
        return $this->finishedDate;
    }

}