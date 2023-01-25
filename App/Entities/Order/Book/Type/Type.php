<?php

namespace App\Entities\Order\Book\Type;

// the type of the book

use App\Traits\Id;
use App\Traits\Title;

class Type implements TypeInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
    ){}

}