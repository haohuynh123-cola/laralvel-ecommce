<?php

namespace App\Support\Query;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait QueryBuilderTrait
{
    protected function applyCommonQueryScopes(Builder $query, Request $request, array $allowedFilters = [], array $allowedSorts = []): Builder
    {
        $query = $this->applyFilters($query, $request, $allowedFilters);
        $query = $this->applySorts($query, $request, $allowedSorts);
        $query = $this->applyIncludes($query, $request);
        return $query;
    }

    protected function applyFilters(Builder $query, Request $request, array $allowedFilters): Builder
    {
        $filters = (array) $request->query('filter', []);
        foreach ($filters as $field => $value) {
            if (! in_array($field, $allowedFilters, true)) {
                continue;
            }
            $query->where($field, is_array($value) ? 'in' : '=', $value);
        }
        return $query;
    }

    protected function applySorts(Builder $query, Request $request, array $allowedSorts): Builder
    {
        $sort = (string) $request->query('sort', '');
        if ($sort === '') {
            return $query;
        }
        $fields = explode(',', $sort);
        foreach ($fields as $field) {
            $direction = 'asc';
            if (str_starts_with($field, '-')) {
                $direction = 'desc';
                $field = substr($field, 1);
            }
            if (! in_array($field, $allowedSorts, true)) {
                continue;
            }
            $query->orderBy($field, $direction);
        }
        return $query;
    }

    protected function applyIncludes(Builder $query, Request $request): Builder
    {
        $include = (string) $request->query('include', '');
        if ($include === '') {
            return $query;
        }
        $relations = array_filter(array_map('trim', explode(',', $include)));
        if ($relations !== []) {
            $query->with($relations);
        }
        return $query;
    }
}
