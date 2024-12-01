<?php

namespace Tests\Unit\UseCases\Book;

use App\Models\Book;
use Core\Domain\Exception\ResourceNotFoundException;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Services\AuthorService;
use Core\Domain\ValueObject\Uuid;
use Core\UseCases\Book\CreateBookUseCase;
use Core\UseCases\Book\DTO\CreateBookDTO;
use Core\UseCases\Book\DTO\UpdateBookDTO;
use Core\UseCases\Book\UpdateBookUseCase;
use \Core\Domain\Entity\Book as BookDomainEntity;
use Tests\TestCase;

class UpdateBookUseCaseTest extends TestCase
{
    private BookRepositoryInterface $bookRepository;

    private UpdateBookUseCase $updateBookUseCase;

    private AuthorService $authorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
        $this->authorService = $this->createMock(AuthorService::class);
        $this->updateBookUseCase = new UpdateBookUseCase($this->bookRepository, $this->authorService);
    }
    public function testUpdateBook(): void
    {
        $bookEntity = Book::factory()->create();
        $dto = new UpdateBookDTO(
            $bookEntity->uuid,
            'book title',
            'book description',
            10,
            1
        );
        $updatedBook = [
            'title' => $dto->title,
            'description' => $dto->description,
            'price' => $dto->price,
            'quantity' => $dto->quantity,
            'author_id' => 1,
        ];

        $authorInfo = [
            'id' => 1,
        ];

        $this->bookRepository->expects($this->once())
            ->method('findBy')
            ->willReturn($bookEntity->toArray());

        $this->bookRepository->expects($this->once())
            ->method('update')
            ->willReturn($dto->toArray());

        $this->bookRepository->expects($this->once())->method('update')
            ->with('uuid', $bookEntity->uuid, $updatedBook)
            ->willReturnCallback(function ($needle, $value, $data) {
                $entity = Book::firstWhere($needle, $value);
                $entity->update($data);
                return $entity->toArray();
            });

        $this->authorService->expects($this->once())
            ->method('findAndCreateAnAuthor')
            ->willReturn($authorInfo);

        $book = $this->updateBookUseCase->handle($dto);

        $this->assertIsArray($book);
        $this->assertEquals($dto->title, $book['title']);
        $this->assertDatabaseHas(
            'tb_book',
            [
                'uuid' => $bookEntity->uuid,
                'title' => $book['title'],
                'description' => $book['description'],
            ]
        );
    }

    public function testThrowErrorWhenBookNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage("Resource \"Book\" not found");
        $dto = new UpdateBookDTO(
            fake()->uuid(),
            'book title',
            'book description',
            10,
            1
        );

        $this->bookRepository->expects($this->once())
            ->method('findBy')
            ->willReturn(null);

        $this->updateBookUseCase->handle($dto);
    }
}
