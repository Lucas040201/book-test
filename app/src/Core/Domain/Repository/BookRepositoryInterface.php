<?php

namespace Core\Domain\Repository;

use Core\Domain\Paginator\PaginatorInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function retrievePaginatedBooks(PaginatorInterface $paginator): LengthAwarePaginator;

}
