<?php

namespace Tests\Unit\UseCases\Book;

use Core\Domain\Paginator\Paginator;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\UseCases\Book\RetrieveBookUseCase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class RetrieveBookUseCaseTest extends TestCase
{
    private BookRepositoryInterface $bookRepository;

    private RetrieveBookUseCase $retrieveBookUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
        $this->retrieveBookUseCase = new RetrieveBookUseCase($this->bookRepository);
    }

    public function testShouldReturnABookPagination(): void
    {
        $paginator = new Paginator(
            1,
            10,
            ['query' => '', 'sort' => 'ASC']
        );
        $pagination = $this->createMock(LengthAwarePaginator::class);
        $this->bookRepository->expects($this->once())->method('retrievePaginatedBooks')
            ->willReturn($pagination);
        $response = $this->retrieveBookUseCase->handle($paginator);
        $this->assertInstanceOf(LengthAwarePaginator::class, $response);
    }
}
