<?php

namespace Tests\Unit\Repositories\Book;

use App\Repositories\Eloquent\BookEloquentRepository;
use Tests\TestCase;

class InsertTest extends TestCase
{
    private BookEloquentRepository $bookEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookEloquentRepository = app(BookEloquentRepository::class);
    }

    public function testInsertAuthor()
    {
        $data = [
            'uuid' => fake()->uuid(),
            'title' => 'John Doe',
            'description' => 'I am a description',
            'price' => 100,
            'quantity' => 1
        ];
        $response = $this->bookEloquentRepository->insert($data);

        $this->assertEquals($data['uuid'], $response['uuid']);
        $this->assertNotEmpty($response['id']);
    }
}
