<?php


namespace App\Services\Exception;


use Throwable;

class NullableUserException extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        $message = "Cannot find user for Your confirme code. Your account can be already confirme. You can try to login or check Your confirmeCode";
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return "{$this->message}";
    }
}