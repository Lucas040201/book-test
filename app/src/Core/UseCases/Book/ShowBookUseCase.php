<?php

namespace Core\UseCases\Book;

use Core\Domain\Exception\ResourceNotFoundException;
use Core\Domain\Repository\BookRepositoryInterface;

class ShowBookUseCase
{

    public function __construct(
        private BookRepositoryInterface $bookRepository
    )
    {
    }


    public function handle(string $bookId)
    {
        $book = $this->bookRepository->findByWithRelation('uuid', $bookId, 'author');

        if (empty($book)) {
           throw new ResourceNotFoundException('Book');
        }

        return $book;
    }
}
