<?php

namespace Core\UseCases\Book\DTO;

use Core\UseCases\DTO\BaseDTO;

class UpdateBookDTO extends BaseDTO
{
    public function __construct(
        protected string $id,
        protected string $title,
        protected string $description,
        protected int $price,
        protected int $quantity
    )
    {
    }
}
