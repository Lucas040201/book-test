<?php

namespace Tests\Unit\Domain\Services;

use App\Models\Author;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\Services\AuthorService;
use Core\Integration\Author\AuthorIntegrationInterface;
use Core\Integration\Author\DTO\AuthorDataDTO;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    private AuthorService $authorService;
    private AuthorIntegrationInterface $authorIntegration;

    private AuthorRepositoryInterface $authorRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorIntegration = $this->createMock(AuthorIntegrationInterface::class);
        $this->authorRepository = $this->createMock(AuthorRepositoryInterface::class);
        $this->authorService = new AuthorService($this->authorIntegration, $this->authorRepository);
    }

    public function testFindAndCreateAnAuthor(): void
    {
        $author = Author::factory()->create();
        $data = [
            'id' => $author->id,
            'uuid' => $author->uuid,
            'name' => $author->name,
            'biography' => $author->biography,
        ];

        $authorDTO = new AuthorDataDTO(
            $data['name'],
            $data['biography'],
        );

        $this->authorIntegration->expects($this->once())
            ->method('getBookAuthor')
            ->willReturn($authorDTO);
        $this->authorRepository->expects($this->once())
            ->method('findBy')
            ->willReturn(null);
        $this->authorRepository->expects($this->once())
            ->method('insert')
            ->willReturn($data);

        $response = $this->authorService->findAndCreateAnAuthor('Quincas Borbas');
        $this->assertSame($data, $response);
    }

    public function testFindAnAuthorWhenTryingToCreate(): void
    {
        $author = Author::factory()->create();
        $data = [
            'id' => $author->id,
            'uuid' => $author->uuid,
            'name' => $author->name,
            'biography' => $author->biography,
        ];

        $authorDTO = new AuthorDataDTO(
            $data['name'],
            $data['biography'],
        );

        $this->authorIntegration->expects($this->once())
            ->method('getBookAuthor')
            ->willReturn($authorDTO);
        $this->authorRepository->expects($this->once())
            ->method('findBy')
            ->willReturn($data);

        $response = $this->authorService->findAndCreateAnAuthor('Quincas Borbas');
        $this->assertSame($data, $response);
    }
}
