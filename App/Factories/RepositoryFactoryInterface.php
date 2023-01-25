<?php

namespace App\Factories;

use App\Entities\EntityInterface;

interface RepositoryFactoryInterface
{
    public function create(EntityInterface $entity);
}