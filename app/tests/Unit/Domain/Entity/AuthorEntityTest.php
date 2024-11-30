<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Author;
use Core\Domain\ValueObject\Uuid;
use Tests\TestCase;

class AuthorEntityTest extends TestCase
{
    public function testCreateAuthorEntity(): void
    {
        $authorName = 'Machado de Assis';
        $entity = new Author(
            $authorName,
            'biography',
            uuid: Uuid::create()
        );

        $this->assertEquals($entity->name, $authorName);
    }
}
