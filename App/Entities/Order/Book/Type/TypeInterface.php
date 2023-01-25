<?php

namespace App\Entities\Order\Book\Type;

use App\Entities\EntityInterface;

interface TypeInterface extends EntityInterface
{
    public function getTitle(): string;
}