<?php

namespace App\Integration\DTO;

use Core\UseCases\DTO\BaseDTO;

class AuthorKeyDTO extends BaseDTO
{
    public function __construct(
        protected string $authorKey
    )
    {
    }
}
