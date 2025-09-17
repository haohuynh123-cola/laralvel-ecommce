<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserIndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'max:255'],
            'ids' => ['sometimes', 'string'], // comma-separated or array in future
            'exclude_ids' => ['sometimes', 'string'],
            'sort' => ['sometimes', 'string'], // e.g. "name,-created_at"
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
