<?php

namespace App\Command\BookType;

use Symfony\Component\HttpFoundation\Request;

interface CreateBookTypeHandlerInterface
{
    function handle(Request $request): void;
}
