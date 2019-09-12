<?php


namespace App\Services\Exception;


use Throwable;

class NullableUserException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
}