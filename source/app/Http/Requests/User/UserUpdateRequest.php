<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;

class UserUpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $userId = (int) ($this->route('user')?->id ?? $this->route('user'));

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $userId],
            'password' => ['sometimes', 'string', 'min:8'],
        ];
    }
}
