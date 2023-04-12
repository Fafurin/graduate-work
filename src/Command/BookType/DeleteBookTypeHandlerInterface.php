<?php

namespace App\Command\BookType;

interface DeleteBookTypeHandlerInterface
{
    function handle(int $id): void;
}
