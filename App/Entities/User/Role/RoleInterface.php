<?php

namespace App\Entities\User\Role;

use App\Entities\EntityInterface;

interface RoleInterface extends EntityInterface
{
    public function getTitle(): string;
}