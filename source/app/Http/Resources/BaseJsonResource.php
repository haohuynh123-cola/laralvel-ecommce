<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseJsonResource extends JsonResource
{
    /**
     * Default wrapper disabled to return flat payload for `data` key.
     */
    public static $wrap = null;

    public function with(Request $request): array
    {
        return [
            'meta' => [
                'success' => true,
                'timestamp' => now()->toIso8601String(),
            ],
        ];
    }
}
