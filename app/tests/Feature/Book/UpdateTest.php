<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Support\Facades\Http;
use Ramsey\Uuid\Uuid;
use Tests\Providers\IntegrationProvider;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testUpdateABook(): void
    {
        $book = Book::factory()->create();
        Http::fake([
            '*' => Http::sequence()
                ->push(IntegrationProvider::getBookResponse())
                ->push(IntegrationProvider::getAuthorResponse())
        ]);
        $data = [
            'title' => 'Quincas Borba',
            'description' => "Machado de Assis",
            'price' => 100,
            'quantity' => 1
        ];
        $response = $this->put("api/v1/book/$book->uuid", $data);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success",
            "request",
            "method",
            "code",
            "error"
        ]);
        $updated = Book::firstWhere('uuid', $book->uuid);
        $this->assertEquals($data['title'], $updated->title);
    }

    public function testThrowErrorWhenBookNotFound(): void
    {
        $uuid = Uuid::uuid4()->toString();

        Http::fake([
            '*' => Http::sequence()
                ->push(IntegrationProvider::getBookResponse())
                ->push(IntegrationProvider::getAuthorResponse())
        ]);
        $data = [
            'title' => 'Quincas Borba',
            'description' => "Machado de Assis",
            'price' => 100,
            'quantity' => 1
        ];
        $response = $this->put("api/v1/book/$uuid", $data);
        $response->assertStatus(404);
        $response->assertJsonStructure([
            "success",
            "request",
            "method",
            "code",
            "error"
        ]);
        $response->assertJson([
            'success' => false,
            'code' => 404,
        ]);
    }
}
