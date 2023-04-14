<?php

namespace App\Command\BookFormat;

use Symfony\Component\HttpFoundation\Request;

interface UpdateBookFormatHandlerInterface
{
    function handle(Request $request, int $id): void;
}
