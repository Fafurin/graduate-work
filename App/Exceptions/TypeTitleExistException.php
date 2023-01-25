<?php

namespace App\Exceptions;

class TypeTitleExistException extends \Exception
{
    protected $message = 'A type with this title already exists';
}