<?php

namespace App\Exceptions;

class OrderNumberExistException extends \Exception
{
    protected $message = 'A order with this number already exists';
}