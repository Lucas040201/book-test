<?php

namespace App\Exception;

use Throwable;

class AuthorNotFoundIntegrationException extends \Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
     parent::__construct('No authors found for this book.', $code, $previous);
    }
}
