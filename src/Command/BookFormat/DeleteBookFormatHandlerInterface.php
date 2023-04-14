<?php

namespace App\Command\BookFormat;

interface DeleteBookFormatHandlerInterface
{
    function handle(int $id): void;
}
