<?php

namespace App\Command\Customer;

use Symfony\Component\HttpFoundation\Request;

interface UpdateCustomerHandlerInterface
{
    function handle(Request $request, int $id): void;
}
