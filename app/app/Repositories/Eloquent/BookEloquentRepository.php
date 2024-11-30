<?php

namespace App\Repositories\Eloquent;

use App\Models\Book;
use Core\Domain\Repository\BookRepositoryInterface;

class BookEloquentRepository extends BaseEloquentRepository implements BookRepositoryInterface
{
    public function __construct()
    {
        $this->model = new (Book::class);
        parent::__construct();
    }
}
