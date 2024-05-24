<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public static function notFoundException(string $message)
    {
        return new static($message, 404);
    }

    public static function badRequestException(string $message)
    {
        return new static($message, 400);
    }
}
