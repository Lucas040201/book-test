<?php

namespace Core\Integration\Author;

use Core\Integration\Author\DTO\AuthorDataDTO;

interface AuthorIntegrationInterface
{
    public function getBookAuthor(string $bookTitle): AuthorDataDTO;
}
