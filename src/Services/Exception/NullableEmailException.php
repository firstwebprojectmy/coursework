<?php


namespace App\Services\Exception;


class NullableEmailException extends \Exception
{
    public function __construct($message = "", $code = 500, \Throwable $previous = null)
    {
        $message = "Incorrect email";
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return "{$this->message}";
    }
}