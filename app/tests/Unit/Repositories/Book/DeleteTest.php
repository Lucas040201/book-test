<?php

namespace Tests\Unit\Repositories\Book;

use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    private BookEloquentRepository $bookEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookEloquentRepository =  app(BookEloquentRepository::class);
    }

    public function testDeleteABook()
    {
        $book = Book::factory()->create();
        $this->bookEloquentRepository->delete('uuid', $book->uuid);
        $this->assertDatabaseEmpty('tb_book');
    }
}
