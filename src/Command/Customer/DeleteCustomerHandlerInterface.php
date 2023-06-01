<?php

namespace App\Command\Customer;

interface DeleteCustomerHandlerInterface
{
    function handle(int $id): void;
}
