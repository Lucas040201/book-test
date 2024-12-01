<?php

namespace Core\UseCases\Book;

use Core\Domain\Paginator\PaginatorInterface;
use Core\Domain\Repository\BookRepositoryInterface;

class RetrieveBookUseCase
{
    public function __construct(
        private BookRepositoryInterface $bookRepository
    )
    {
    }


    public function handle(PaginatorInterface $paginator)
    {
        return $this->bookRepository->retrievePaginatedBooks($paginator);
    }
}
