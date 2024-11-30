<?php

namespace Tests\Feature\Book;

use Illuminate\Support\Facades\Http;
use Tests\Providers\IntegrationProvider;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCreateABook(): void
    {
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
        $response = $this->post('api/v1/book', $data);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            "success",
            "request",
            "method",
            "code",
            "error"
        ]);
    }
}
