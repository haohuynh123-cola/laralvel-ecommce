<?php

namespace App\Repositories;

use App\Contracts\Repository\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

abstract class BaseRepository implements RepositoryInterface
{
    /** @var class-string<Model> */
    protected string $model;

    public function __construct()
    {
        if (! isset($this->model)) {
            throw new InvalidArgumentException('Property $modelClass must be set to an Eloquent model class.');
        }
    }

    public function getModelClass(): string
    {
        return $this->model;
    }

    public function query(): Builder
    {
        return forward_static_call([$this->model, 'query']);
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage);
    }

    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        /** @var Model */
        return $this->query()->findOrFail($id, $columns);
    }

    public function create(array $attributes): Model
    {
        /** @var Model $model */
        $model = new $this->model($attributes);
        $model->save();
        return $model;
    }

    public function update(int|string|Model $modelOrId, array $attributes): Model
    {
        $model = $modelOrId instanceof Model ? $modelOrId : $this->findOrFail($modelOrId);
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    public function delete(int|string|Model $modelOrId): bool
    {
        $model = $modelOrId instanceof Model ? $modelOrId : $this->findOrFail($modelOrId);
        return (bool) $model->delete();
    }
}
