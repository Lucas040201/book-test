<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Book;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid;
use \Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;

class BookEntityTest extends TestCase
{
    public function testCreateAValidBookEntity(): void
    {
        $title = 'Book Title';
        $description = 'Book Description';
        $price = 100;
        $uuid = new Uuid(RamseyUuid::uuid4()->toString());
        $entity = new Book(
            $title,
            $description,
            $price,
            uuid: $uuid
        );

        $this->assertEquals($entity->title, $title);
        $this->assertEquals($entity->description, $description);
        $this->assertEquals($entity->price, $price);
        $this->assertEquals(0, $entity->quantity);
    }

    public function testThrowErrorWhenCreateInvalidEntity(): void
    {
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage('The value must be at least 3 characters');

        $title = 'B';
        $description = 'Book Description';
        $price = 100;

        new Book(
            $title,
            $description,
            $price
        );
    }
}
