<?php

namespace Core\Domain\Exception;

class ResourceNotFoundException extends \Exception
{
    public function __construct(string $resource, int $code = 404, ?Throwable $previous = null)
    {
        $message = "Resource \"{$resource}\" not found";
        parent::__construct($message, $code, $previous);
    }
}
