<?php

namespace Tests\Unit\UseCases\Book;

use App\Models\Book;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\UseCases\Book\DeleteBookUseCase;
use Tests\TestCase;

class DeleteBookUseCaseTest extends TestCase
{
    private BookRepositoryInterface $bookRepository;

    private DeleteBookUseCase $deleteBookUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);

        $this->deleteBookUseCase = new DeleteBookUseCase($this->bookRepository);
    }

    public function testDeleteBook(): void
    {
        $book = Book::factory()->create();
        $uuid = new Uuid($book->uuid);
        $this->assertDatabaseHas('tb_book', [
            'id' => $book->id,
            'uuid' => $uuid,
        ]);
        $this->bookRepository->expects($this->once())->method('delete')
            ->with('uuid', $uuid)
            ->willReturnCallback(function ($needle, $value) {
                Book::where($needle, $value)->delete();
        });
        $this->deleteBookUseCase->handle($book->uuid);
        $this->assertDatabaseEmpty('tb_book');
    }
}
