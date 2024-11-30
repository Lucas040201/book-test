<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use Core\Domain\Repository\AuthorRepositoryInterface;

class AuthorEloquentRepository extends BaseEloquentRepository implements AuthorRepositoryInterface
{

    public function __construct()
    {
        $this->model = new (Author::class);
        parent::__construct();
    }

    public function findAuthorByBookName(string $bookTitle): ?array
    {
        return $this->builder->select('tb_author.*')->whereLike('tb_book.title', "%$bookTitle%")->join(
            'tb_book',
            'tb_book.author_id',
            '=',
            'tb_author.id'
        )->first()?->toArray();
    }
}
