<?php

namespace App\Exceptions;

class RoleTitleExistException extends \Exception
{
    protected $message = 'A role with this title already exists';
}