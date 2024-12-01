<?php

namespace Core\UseCases\Book;

use Core\Domain\Entity\Book as Entity;
use Core\Domain\Exception\ResourceNotFoundException;
use Core\Domain\Repository\BookRepositoryInterface;
use Core\Domain\Services\AuthorService;
use Core\Domain\ValueObject\Uuid;
use Core\UseCases\Book\DTO\UpdateBookDTO;

class UpdateBookUseCase
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
        private readonly AuthorService $authorService
    )
    {
    }

    private function createEntity(UpdateBookDTO $updateBookDTO): Entity
    {
        $bookUuid = new Uuid($updateBookDTO->id);
        return new Entity(
            title: $updateBookDTO->title,
            description: $updateBookDTO->description,
            price: $updateBookDTO->price,
            quantity: $updateBookDTO->quantity,
            uuid: $bookUuid,
        );
    }

    public function handle(UpdateBookDTO $updateBookDTO): array
    {
        $bookEntity = $this->createEntity($updateBookDTO);

        if(empty($this->bookRepository->findBy('uuid', $bookEntity->uuid))) {
            throw new ResourceNotFoundException('Book');
        }

        $author = $this->authorService->findAuthorByBookName($bookEntity->title);

        if(empty($author['id'])) {
            $author = $this->authorService->findAndCreateAnAuthor($bookEntity->title);
        }

        return $this->bookRepository->update(
            'uuid',
            $bookEntity->uuid,
            [
                'title' => $bookEntity->title,
                'description' => $bookEntity->description,
                'price' => $bookEntity->price,
                'quantity' => $bookEntity->quantity,
                'author_id' => $author['id'],
            ]
        );
    }
}
