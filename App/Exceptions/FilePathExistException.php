<?php

namespace App\Exceptions;

class FilePathExistException extends \Exception
{
    protected $message = 'A file with this path already exists';

}