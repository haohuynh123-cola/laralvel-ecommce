<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository
{

    protected string $model = \App\Models\User::class;

    public function getListUser(array $query, int $perPage = 15): LengthAwarePaginator
    {
        $q = $this->query();

        if (!empty($query['name'])) {
            $q->where('name', 'like', '%' . $query['name'] . '%');
        }
        if (!empty($query['email'])) {
            $q->where('email', 'like', '%' . $query['email'] . '%');
        }
        if (!empty($query['ids'])) {
            $q->idIn($query['ids']);
        }
        if (!empty($query['exclude_ids'])) {
            $q->idNotIn($query['exclude_ids']);
        }
        if (!empty($query['sort'])) {
            foreach (explode(',', (string) $query['sort']) as $field) {
                $dir = str_starts_with($field, '-') ? 'desc' : 'asc';
                $field = ltrim($field, '-');
                $q->orderBy($field, $dir);
            }
        }

        return $q->paginate($perPage);
    }

    public function findManyByIds(array|string $ids): Collection
    {
        return $this->query()->idIn($ids)->get();
    }
}
