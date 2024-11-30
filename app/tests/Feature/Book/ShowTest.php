<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function testFindABook(): void
    {
        $book = Book::Factory()->create();

        $headers = [
            'Accept' => 'application/json',
        ];

        $response = $this->get("api/v1/book/{$book->uuid}", $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data'
            ]
        );
    }

    public function testBookNotFound(): void
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        $randomUUid = Uuid::uuid4()->toString();
        $response = $this->get("api/v1/book/{$randomUUid}", $headers);

        $response->assertStatus(404);

        $response->assertJsonStructure(
            [
                "success",
                "request",
                "method",
                "code",
                "error"
            ]
        );
    }
}
