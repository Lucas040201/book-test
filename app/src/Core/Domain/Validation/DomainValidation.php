<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    /**
     * @throws EntityValidationException
     */
    public static function notNull(string $value, string $exceptMessage = null): void
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? 'Should not be empty or null');
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strMaxLength(string $value, int $length = 255, string $exceptMessage = null): void
    {
        if (strlen($value) >= $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strMinLength(string $value, int $length = 3, string $exceptMessage = null): void
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must be at least {$length} characters");
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strCanNullAndMaxLength(string $value = '', int $length = 255, string $exceptMessage = null): void
    {
        if (! empty($value) && strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
        }
    }
}
