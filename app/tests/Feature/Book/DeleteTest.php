<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function testDeleteBook(): void
    {
        $book = Book::factory()->create();
        $this->assertDatabaseHas(
            'tb_book',
            [
                'id' => $book->id,
            ]
        );
        $response = $this->delete("api/v1/book/$book->uuid");
        $response->assertStatus(200);
        $this->assertDatabaseEmpty('tb_book');
        $this->assertTrue($response->json('success'));
    }
}
