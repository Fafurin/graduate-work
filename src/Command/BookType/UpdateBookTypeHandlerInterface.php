<?php

namespace App\Command\BookType;

use Symfony\Component\HttpFoundation\Request;

interface UpdateBookTypeHandlerInterface
{
    function handle(Request $request, int $id): void;
}
