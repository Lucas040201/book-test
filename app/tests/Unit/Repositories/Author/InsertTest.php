<?php

namespace Tests\Unit\Repositories\Author;

use App\Repositories\Eloquent\AuthorEloquentRepository;
use Tests\TestCase;

class InsertTest extends TestCase
{
    private AuthorEloquentRepository $authorEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorEloquentRepository = app(AuthorEloquentRepository::class);
    }

    public function testInsertAuthor()
    {
        $data = [
            'uuid' => fake()->uuid(),
            'name' => 'John Doe',
            'biography' => 'I am a biography',
        ];
        $response = $this->authorEloquentRepository->insert($data);

        $this->assertNotEmpty($response['id']);
        $this->assertEquals($data['name'], $response['name']);
        $this->assertEquals($data['biography'], $response['biography']);
    }
}
