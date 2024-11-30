<?php

namespace Core\Domain\Repository;

interface AuthorRepositoryInterface extends BaseRepositoryInterface
{
    public function findAuthorByBookName(string $bookTitle): ?array;
}
