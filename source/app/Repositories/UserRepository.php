<?php

namespace App\Repositories;

use App\Support\Query\QueryBuilderTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository
{
    use QueryBuilderTrait;

    protected string $model = \App\Models\User::class;

    public function paginateWithRequest(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->applyCommonQueryScopes(
            $this->query(),
            $request,
            allowedFilters: ['id', 'name', 'email'],
            allowedSorts: ['id', 'name', 'email', 'created_at']
        );

        return $query->paginate($perPage);
    }
}
