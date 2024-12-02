<?php

namespace Core\UseCases\Book;

use Core\Domain\Exception\ResourceNotFoundException;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\ValueObject\Uuid;

class ShowBookUseCase
{

    public function __construct(
        private BookRepositoryInterface $bookRepository
    )
    {
    }


    public function handle(string $bookId)
    {
        $uuid = new Uuid($bookId);
        $book = $this->bookRepository->findByWithRelation('uuid', $uuid, 'author');

        if (empty($book)) {
           throw new ResourceNotFoundException('Book');
        }

        return $book;
    }
}
