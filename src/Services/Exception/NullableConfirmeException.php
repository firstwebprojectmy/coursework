<?php


namespace App\Services\Exception;


use Throwable;

class NullableConfirmeException extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        $message = "This link is not valid. Please check Your link";
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return "{$this->message}";
    }
}