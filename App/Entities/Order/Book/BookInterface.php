<?php

namespace App\Entities\Order\Book;

use App\Entities\EntityInterface;

interface BookInterface extends EntityInterface
{
    public function getTitle(): string;
}