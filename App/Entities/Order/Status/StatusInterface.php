<?php

namespace App\Entities\Order\Status;

use App\Entities\EntityInterface;

interface StatusInterface extends EntityInterface
{
    public function getTitle(): string;
}