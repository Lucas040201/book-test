<?php

namespace Repositories\Author;

use App\Models\Author as AuthorModel;
use App\Repositories\Eloquent\AuthorEloquentRepository;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class FindByTest extends TestCase
{

    private AuthorEloquentRepository $authorEloquentRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorEloquentRepository = new AuthorEloquentRepository();
    }

    public function testFindBook(): void
    {

        $author = AuthorModel::factory()->create();
        $response = $this->authorEloquentRepository->findBy('uuid', $author->uuid);
        $this->assertIsArray($response);
        $this->assertEquals($response['uuid'], $author->uuid);
    }

    public function testRetrieveNullWhenBookNotFound(): void
    {
        $response = $this->authorEloquentRepository->findBy('uuid', Uuid::uuid4()->toString());
        $this->assertNull($response);
    }
}
