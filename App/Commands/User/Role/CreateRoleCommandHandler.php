<?php

namespace App\Commands\User\Role;

use App\Commands\CommandHandlerInterface;
use App\Commands\CommandInterface;
use App\Connections\ConnectorInterface;
use App\Connections\PostgresConnector;
use App\Entities\User\Role\Role;
use App\Exceptions\RoleNotFoundException;
use App\Exceptions\RoleTitleExistException;
use App\Repositories\User\Role\RoleRepository;
use App\Repositories\User\Role\RoleRepositoryInterface;

class CreateRoleCommandHandler implements CommandHandlerInterface
{

    private \PDOStatement|false $statement;

    public function __construct(
        private ?RoleRepositoryInterface $roleRepository = null,
        private ?ConnectorInterface $connector = null
    )
    {
        $this->roleRepository = $roleRepository ?? new RoleRepository();
        $this->connector = $connector ?? new PostgresConnector();
        $this->statement = $this->connector->getConnection()->prepare($this->getSQL());
    }

    /**
     * @throws RoleTitleExistException
     */
    public function handle(CommandInterface $command): void
    {
        /**
         * @var Role $role
         */

        $role = $command->getEntity();
        $title = $role->getTitle();

        if (!$this->isRoleExists($title)) {
            $this->statement->execute([':title' => $title]);
        } else throw new RoleTitleExistException();
    }

    private function isRoleExists(string $title): bool
    {
        try {
            $this->roleRepository->getRoleByTitle($title);
        } catch (RoleNotFoundException) {
            return false;
        }

        return true;
    }

    public function getSQL(): string
    {
        return "INSERT INTO roles (title) VALUES (:title)";
    }
}