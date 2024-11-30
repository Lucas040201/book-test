<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Author extends BaseEntity
{
    public function __construct(
        protected string $name,
        protected string $biography,
        protected ?int $id = null,
        protected ?Uuid $uuid = null,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        DomainValidation::strMinLength($this->name);
    }
}
