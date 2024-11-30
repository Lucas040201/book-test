<?php

namespace Tests\Unit\UseCases\Book;

use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Services\AuthorService;
use Core\UseCases\Book\CreateBookUseCase;
use Core\UseCases\Book\DTO\CreateBookDTO;
use Tests\TestCase;

class CreateBookUseCaseTest extends TestCase
{


    private BookRepositoryInterface $bookRepository;

    private CreateBookUseCase $createBookUseCase;

    private AuthorService $authorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
        $this->authorService = $this->createMock(AuthorService::class);
        $this->createBookUseCase = new CreateBookUseCase($this->bookRepository, $this->authorService);
    }


    public function testShouldCreateBook(): void
    {

        $dto = new CreateBookDTO(
            'book title',
            'book description',
            10,
            1
        );

        $authorInfo = [
            'id' => 1,
        ];

        $this->bookRepository->expects($this->once())
            ->method('insert')
            ->willReturn($dto->toArray());

        $this->authorService->expects($this->once())
            ->method('findAndCreateAnAuthor')
            ->willReturn($authorInfo);

        $book = $this->createBookUseCase->handle($dto);

        $this->assertIsArray($book);
        $this->assertEquals($dto->title, $book['title']);
    }


}
