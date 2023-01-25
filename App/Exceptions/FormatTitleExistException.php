<?php

namespace App\Exceptions;

class FormatTitleExistException extends \Exception
{
    protected $message = 'A format with this title already exists';

}