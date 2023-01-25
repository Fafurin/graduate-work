<?php

namespace App\Entities\User\Position;

// user position

use App\Traits\Id;
use App\Traits\Title;

class Position implements PositionInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
    ){}

}