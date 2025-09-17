<?php

namespace App\Services;

use App\Contracts\Repository\RepositoryInterface;
use App\Contracts\Service\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements ServiceInterface
{
    public function __construct(protected RepositoryInterface $repository) {}

    public function all(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->repository->find($id, $columns);
    }

    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        return $this->repository->findOrFail($id, $columns);
    }

    public function create(array $attributes): Model
    {
        return $this->repository->create($attributes);
    }

    public function update(int|string|Model $modelOrId, array $attributes): Model
    {
        return $this->repository->update($modelOrId, $attributes);
    }

    public function delete(int|string|Model $modelOrId): bool
    {
        return $this->repository->delete($modelOrId);
    }
}
