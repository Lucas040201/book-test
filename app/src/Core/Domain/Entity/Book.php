<?php

namespace Core\Domain\Entity;

use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Book extends BaseEntity
{

    public function __construct(
        protected string $title,
        protected string $description,
        protected int $price = 0,
        protected int $quantity = 0,
        protected ?int $id = null,
        protected ?Uuid $uuid = null,
        protected ?string $authorId = null,
    )
    {
        $this->validate();
    }

    private function validate()
    {
        DomainValidation::strMinLength($this->title);
    }

}
