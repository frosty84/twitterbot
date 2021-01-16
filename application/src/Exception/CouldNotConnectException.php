<?php

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

class CouldNotConnectException extends Exception
{
    private const MESSAGE = "Could not connect to Twitter.";

    public function __construct($message = self::MESSAGE, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
