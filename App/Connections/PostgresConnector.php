<?php

namespace App\Connections;

use App\config\PostgresConfig;

class PostgresConnector extends Connector implements PostgresConnectorInterface
{
    public function getDsn(): string
    {
        return PostgresConfig::DSN;
    }

    public function getUserName(): string
    {
        return PostgresConfig::USERNAME;
    }

    public function getPassword(): string
    {
        return PostgresConfig::PASSWORD;
    }

    public function getOptions(): array
    {
        return [];
    }
}