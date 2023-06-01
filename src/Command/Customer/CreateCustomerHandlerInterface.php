<?php

namespace App\Command\Customer;

use Symfony\Component\HttpFoundation\Request;

interface CreateCustomerHandlerInterface
{
    function handle(Request $request): void;
}
