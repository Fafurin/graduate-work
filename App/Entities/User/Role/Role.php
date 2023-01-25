<?php

namespace App\Entities\User\Role;

// user roles

use App\Traits\Id;
use App\Traits\Title;

class Role implements RoleInterface
{

    use Id;
    use Title;

    public function __construct(
        private string $title,
    ){}

}