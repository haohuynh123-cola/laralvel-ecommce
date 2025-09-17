<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaginatedResource
{
    /**
     * Wrap a resource collection with pagination meta in a consistent structure.
     */
    public static function make(AnonymousResourceCollection $collection, LengthAwarePaginator $paginator, Request $request): array
    {
        return [
            'data' => $collection,
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'prev_page_url' => $paginator->previousPageUrl(),
                'next_page_url' => $paginator->nextPageUrl(),
            ],
            'meta' => [
                'success' => true,
                'timestamp' => now()->toIso8601String(),
                'path' => $request->path(),
            ],
        ];
    }
}
