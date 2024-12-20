<?php

namespace App\Repositories\Eloquent;

use Core\Domain\Paginator\PaginatorInterface;
use Core\Domain\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseEloquentRepository implements BaseRepositoryInterface
{
    protected Model $model;

    protected Builder $builder;

    public function __construct()
    {
        $this->refreshBuilder();
    }

    protected function refreshBuilder()
    {
        $this->builder = $this->model->newQuery();
    }

    /**
     * @throws \Exception
     */
    public function insert(array $data): array
    {
        $resource = $this->model::create($data);
        return $resource->toArray();
    }

    /**
     * @throws \Exception
     */
    public function findBy(string $needle, string $value): array | null
    {
        $resource = $this->model::firstWhere($needle, $value);
        return $resource?->toArray();
    }

    public function delete(string $needle, $value): void
    {
        $this->model::where($needle, $value)->delete();
    }

    public function update(string $needle, $value, array $data): array
    {
        $entity = $this->builder->firstWhere($needle, $value);
        $entity->update($data);
        $this->refreshBuilder();
        return $entity->toArray();
    }

    public function index(PaginatorInterface $paginator): LengthAwarePaginator
    {
        return $this->model::paginate($paginator->getPageSize(), ['*'], 'page', $paginator->getPage());
    }

    /**
     * @throws \Exception
     */
    public function fieldExists(string $field, $value): bool
    {
        return !!$this->findBy($field, $value);
    }

    public function findByWithRelation(string $needle, string $value, string $relation): ?array
    {
        return $this->model::with($relation)->where($needle, $value)->first()?->toArray();
    }

}
