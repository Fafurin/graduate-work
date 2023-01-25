<?php

namespace App\Exceptions;

class StatusTitleExistException extends \Exception
{
    protected $message = 'A status with this title already exists';
}