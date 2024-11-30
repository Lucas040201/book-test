<?php

namespace Tests\Unit\Repositories\Book;

use App\Models\Book as BookModel;
use App\Repositories\Eloquent\BookEloquentRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class FindByWithRelationTest extends TestCase
{
    private BookEloquentRepository $bookEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookEloquentRepository = new BookEloquentRepository();
    }

    public function testFindBook(): void
    {

        $book = BookModel::factory()->create();
        $response = $this->bookEloquentRepository
            ->findByWithRelation('uuid', $book->uuid, 'author');
        $this->assertIsArray($response);
        $this->assertEquals($response['uuid'], $book->uuid);
    }

    public function testRetrieveNullWhenBookNotFound(): void
    {
        $response = $this->bookEloquentRepository
            ->findByWithRelation('uuid', Uuid::uuid4()->toString(), 'author');
        $this->assertNull($response);
    }
}
