<?php

namespace App\Command\BookFormat;

use Symfony\Component\HttpFoundation\Request;

interface CreateBookFormatHandlerInterface
{
    function handle(Request $request): void;
}
