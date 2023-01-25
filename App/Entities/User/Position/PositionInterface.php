<?php

namespace App\Entities\User\Position;

use App\Entities\EntityInterface;

interface PositionInterface extends EntityInterface
{
    public function getTitle(): string;
}