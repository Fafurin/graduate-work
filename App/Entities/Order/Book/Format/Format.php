<?php

namespace App\Entities\Order\Book\Format;

// the format of the book

use App\Traits\Id;
use App\Traits\Title;

class Format implements FormatInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
        private string $size,
    ){}

    public function getSize(): string
    {
        return $this->size;// TODO: Implement getSize() method.
    }

}