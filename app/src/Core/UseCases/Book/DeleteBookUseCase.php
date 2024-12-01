<?php

namespace Core\UseCases\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\ValueObject\Uuid;

class DeleteBookUseCase
{
    public function __construct(
        private BookRepositoryInterface $bookRepository
    )
    {
    }

    public function handle(string $bookId): void
    {
        $uuid = new Uuid($bookId);
        $this->bookRepository->delete('uuid', $uuid);
    }
}
