<?php

namespace App\Exceptions;

class BookISBNExistException extends \Exception
{
    protected $message = 'A book with this ISBN already exists';
}