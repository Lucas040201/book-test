<?php

namespace Core\Domain\ValueObject;

use Core\Domain\Exception\EntityValidationException;
use \Ramsey\Uuid\Uuid as BaseUuid;

class Uuid
{

    public function __construct(
        protected ?string $uuid = null
    )
    {
        $this->validate();
    }

    public function __get(string $name)
    {
        return $this->{$name};
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public static function create(): self
    {
        return new self(BaseUuid::uuid4()->toString());
    }

    private function validate()
    {
        if (!BaseUuid::isValid($this->uuid)) {
            throw new EntityValidationException("Uuid is not valid");
        }
    }
}
