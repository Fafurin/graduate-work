<?php

namespace App\Exceptions;

class PositionTitleExistException extends \Exception
{
    protected $message = 'A position with this title already exists';
}