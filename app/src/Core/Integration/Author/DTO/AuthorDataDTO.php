<?php

namespace Core\Integration\Author\DTO;

use Core\UseCases\DTO\BaseDTO;

class AuthorDataDTO extends BaseDTO
{

    public function __construct(
        protected string $name,
        protected string $biography,
    )
    {
    }

}
