<?php

namespace Tests\Unit\Repositories\Book;

use App\Models\Book;
use App\Repositories\Eloquent\BookEloquentRepository;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    private BookEloquentRepository $bookEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookEloquentRepository = app(BookEloquentRepository::class);
    }

    public function testUpdateBook()
    {
        $book = Book::factory()->create();
        $data = [
            'title' => 'John Doe',
            'description' => 'I am a description',
            'price' => 100,
            'quantity' => 1
        ];
        $response = $this->bookEloquentRepository->update('uuid', $book->uuid, $data);
        $this->assertEquals($data['title'], $response['title']);
        $this->assertEquals($data['description'], $response['description']);
        $this->assertEquals($data['price'], $response['price']);
        $this->assertEquals($data['quantity'], $response['quantity']);

    }
}
