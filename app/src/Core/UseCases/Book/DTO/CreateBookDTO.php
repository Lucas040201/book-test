<?php

namespace Core\UseCases\Book\DTO;

use Core\UseCases\DTO\BaseDTO;

class CreateBookDTO extends BaseDTO
{
    public function __construct(
        protected string $title,
        protected string $description,
        protected int $price,
        protected int $quantity
    )
    {
    }
}
