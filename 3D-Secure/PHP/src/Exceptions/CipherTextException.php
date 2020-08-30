<?php

namespace PagoFacil\ThreeDSecure\Exceptions;

use Exception;
use Throwable;

class CipherTextException extends Exception
{
    /**
     * CipherTextException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    private function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return CipherTextException
     */
    public static function format()
    {
        return new static('corrupt encrypted message');
    }
}
