<?php

namespace Core\Domain\Repository;

use Core\Domain\Paginator\PaginatorInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function findBy(string $needle, string $value): array|null;
    public function update(string $needle, $value, array $data);
    public function delete(string $needle, $value): void;
    public function insert(array $data): array;
    public function index(PaginatorInterface $paginator): LengthAwarePaginator;
    public function fieldExists(string $field, $value): bool;

    public function findByWithRelation(string $needle, string $value, string $relation): ?array;
}
