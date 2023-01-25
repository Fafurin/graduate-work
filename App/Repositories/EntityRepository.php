<?php

namespace App\Repositories;

use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\EntityInterface;

abstract class EntityRepository implements EntityRepositoryInterface
{

    public function __construct(protected ?ConnectorInterface $connector = null)
    {
        $this->connector = $connector ?? new PostgresConnector();
    }

    abstract public function get(int $id): EntityInterface;

}