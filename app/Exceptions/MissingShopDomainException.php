<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class MissingShopDomainException extends Exception
{
    /**
     * MissingShopDomainException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "No shop domain", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
