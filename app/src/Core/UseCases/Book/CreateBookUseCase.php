<?php

namespace Core\UseCases\Book;

use Core\Domain\Entity\Book as Entity;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Services\AuthorService;
use Core\Domain\ValueObject\Uuid;
use Core\UseCases\Book\DTO\CreateBookDTO;

class CreateBookUseCase
{

    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly AuthorService $authorService
    )
    {
    }

    private function createEntity(CreateBookDTO $createBookDTO): Entity
    {
        return new Entity(
            title: $createBookDTO->title,
            description: $createBookDTO->description,
            price: $createBookDTO->price,
            quantity: $createBookDTO->quantity,
            uuid: Uuid::create(),
        );
    }

    public function handle(CreateBookDTO $bookDTO): array
    {
        $author = $this->authorService->findAuthorByBookName($bookDTO->title);

        if(empty($author['id'])) {
            $author = $this->authorService->findAndCreateAnAuthor($bookDTO->title);
        }

        $book = $this->createEntity($bookDTO);

        return $this->bookRepository->insert(
            [
                'title' => $book->title,
                'description' => $book->description,
                'price' => $book->price,
                'quantity' => $book->quantity,
                'uuid' => $book->uuid->uuid,
                'author_id' => $author['id'],
            ]
        );
    }

}
