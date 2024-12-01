<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use Core\Domain\Paginator\PaginatorInterface;
use Core\Domain\Repository\BookRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BookEloquentRepository extends BaseEloquentRepository implements BookRepositoryInterface
{
    public function __construct()
    {
        $this->model = new (Book::class);
        parent::__construct();
    }

    public function retrievePaginatedBooks(PaginatorInterface $paginator): LengthAwarePaginator
    {
        $params = $paginator->getParams();
        $query = $params['query'] ?? '';
        $results = $this->builder
            ->with('author');

        if (!empty($query)) {
            $results->orWhere(function ($queryBuilder) use ($query) {
                $queryBuilder->orWhereRaw('LOWER(tb_book.title) LIKE ?', ["%" . strtolower($query) . "%"])
                    ->orWhereRaw('LOWER(tb_book.description) LIKE ?', ["%" . strtolower($query) . "%"]);
            });
        }

        $results->orderBy('title', $params['sort']);
        $paginator = $results->paginate($paginator->getPageSize(), ['*'], 'page', $paginator->getPage());
        $this->refreshBuilder();
        return $paginator;
    }
}
