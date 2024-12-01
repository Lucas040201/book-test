<?php

namespace Tests\Unit\Repositories\Book;


use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Core\Domain\Paginator\Paginator;
use Tests\TestCase;

class RetrievePaginatedBooksTest extends TestCase
{
    private BookEloquentRepository $bookEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookEloquentRepository =  app(BookEloquentRepository::class);
    }

    public function testGetPaginatedBooks(): void
    {
        Book::factory()->count(5)->create();
        $paginator = new Paginator(
            1,
            10,
            ['query' => '', 'sort' => 'ASC']
        );
        $books = $this->bookEloquentRepository->retrievePaginatedBooks($paginator);
        $this->assertEquals(5, $books->count());
    }

    public function testGetPaginatedBooksWithQuery(): void
    {
        Book::factory()->count(5)->create();
        Book::factory()->create(['title' => 'test']);
        $paginator = new Paginator(
            1,
            10,
            ['query' => 'test', 'sort' => 'ASC']
        );
        $books = $this->bookEloquentRepository->retrievePaginatedBooks($paginator);
        $this->assertEquals(1, $books->count());
    }

}
