<?php

namespace Tests\Unit\Repositories\Author;

use App\Models\Author as AuthorModel;
use App\Models\Book;
use App\Repositories\Eloquent\AuthorEloquentRepository;
use Tests\TestCase;

class FindAuthorByBookNameTest extends TestCase
{
    private AuthorEloquentRepository $authorEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorEloquentRepository = app(AuthorEloquentRepository::class);
    }

    public function testFindBook(): void
    {
        $author = AuthorModel::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        $response = $this->authorEloquentRepository->findAuthorByBookName($book->title);
        $this->assertIsArray($response);
        $this->assertEquals($response['uuid'], $book->author()->first()->uuid);
    }

    public function testRetrieveNullWhenBookNotFound(): void
    {
        $response = $this->authorEloquentRepository->findAuthorByBookName('Quincas Borba');
        $this->assertNull($response);
    }
}
