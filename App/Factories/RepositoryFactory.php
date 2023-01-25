<?php

namespace App\Factories;

use App\Connections\ConnectorInterface;
use App\Entities\EntityInterface;
use App\Entities\Order\Book\Book;
use App\Entities\Order\Book\File\File;
use App\Entities\Order\Book\Format\Format;
use App\Entities\Order\Book\Type\Type;
use App\Entities\Order\Order;
use App\Entities\Order\Status\Status;
use App\Entities\Task\Task;
use App\Entities\User\Customer\Customer;
use App\Entities\User\Employee\Employee;
use App\Entities\User\Position\Position;
use App\Entities\User\Role\Role;
use App\Repositories\Order\Book\BookRepository;
use App\Repositories\Order\Book\File\FileRepository;
use App\Repositories\Order\Book\Format\FormatRepository;
use App\Repositories\Order\Book\Type\TypeRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\Status\StatusRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\Customer\CustomerRepository;
use App\Repositories\User\Employee\EmployeeRepository;
use App\Repositories\User\Position\PositionRepository;
use App\Repositories\User\Role\RoleRepository;

class RepositoryFactory implements RepositoryFactoryInterface
{

    public function __construct(private ConnectorInterface $connector){}

    public function create(EntityInterface $entity)
    {
        return match ($entity::class)
        {
            Customer::class => new CustomerRepository($this->connector),
            Book::class => new BookRepository($this->connector),
            Order::class => new OrderRepository($this->connector),
            Task::class => new TaskRepository($this->connector),
            Role::class => new RoleRepository($this->connector),
            Position::class => new PositionRepository($this->connector),
            Employee::class => new EmployeeRepository($this->connector),
            Format::class => new FormatRepository($this->connector),
            Type::class => new TypeRepository($this->connector),
            File::class => new FileRepository($this->connector),
            Status::class => new StatusRepository($this->connector),
        };
    }
}