<?php

namespace Core\Domain\Services;

use Core\Domain\Entity\Author;
use Core\Domain\Repository\AuthorRepositoryInterface;
use Core\Domain\ValueObject\Uuid;
use Core\Integration\Author\AuthorIntegrationInterface;

class AuthorService
{
    public function __construct(
        private AuthorIntegrationInterface $authorIntegration,
        private AuthorRepositoryInterface $authorRepository
    )
    {
    }

    public function findAndCreateAnAuthor(string $bookTitle): array
    {
        $authorInfo = $this->authorIntegration->getBookAuthor($bookTitle);

        $author = $this->authorRepository->findBy('name', $authorInfo->name);
        if(!empty($author)) {
            return $author;
        }

        $authorEntity = new Author(
            $authorInfo->name,
            $authorInfo->biography,
            uuid: Uuid::create()
        );

        return $this->authorRepository->insert(
            [
                'uuid' => $authorEntity->uuid->uuid,
                'name' => $authorEntity->name,
                'biography' => $authorEntity->biography,
            ]
        );
    }

    public function findAuthorByBookName(string $bookTitle): ?array
    {
        return $this->authorRepository->findAuthorByBookName($bookTitle);
    }
}
