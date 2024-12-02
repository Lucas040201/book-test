<?php

namespace Tests\Unit\UseCases\Book;

use App\Models\Book as BookModel;
use Core\Domain\Exception\ResourceNotFoundException;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\UseCases\Book\ShowBookUseCase;
use Tests\TestCase;

class ShowBookUseCaseTest extends TestCase
{

    private BookRepositoryInterface $bookRepository;

    private ShowBookUseCase $showBookUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);

        $this->showBookUseCase = new ShowBookUseCase($this->bookRepository);

    }

    public function testShouldShowBook(): void
    {
        $book = BookModel::factory()->create();
        $expectedBook = [
            'id' => $book->id,
            'uuid' => $book->uuid,
            'title' => $book->title,
            'description' => $book->description,
            'price' => $book->price,
            'quantity' => $book->quantity,
            'author_id' => null,
        ];
        $this->bookRepository
            ->expects($this->once())
            ->method('findByWithRelation')
            ->willReturn($expectedBook);
        $response = $this->showBookUseCase->handle($book->uuid);
        $this->assertSame($expectedBook, $response);
    }

    public function testShouldThrowErrorWhenBookNotFound(): void
    {
        $valueUuid = Uuid::create();
        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('Resource "Book" not found');
        $this->bookRepository
            ->expects($this->once())
            ->method('findByWithRelation')
            ->willReturn(null);
        $this->showBookUseCase->handle($valueUuid->uuid);
    }

}
