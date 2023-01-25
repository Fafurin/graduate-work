<?php

namespace App\Entities\Order\Status;

// the order status

use App\Traits\Id;
use App\Traits\Title;

class Status implements StatusInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
    ){}

}