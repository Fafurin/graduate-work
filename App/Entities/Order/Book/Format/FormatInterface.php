<?php

namespace App\Entities\Order\Book\Format;

use App\Entities\EntityInterface;

interface FormatInterface extends EntityInterface
{
    public function getTitle(): string;
    public function getSize(): string;
}