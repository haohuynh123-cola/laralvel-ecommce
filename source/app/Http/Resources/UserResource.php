<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseJsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at ? date('Y-m-d H:i:s', strtotime($this->email_verified_at)) : null,
            'created_at' => $this->created_at ? date('Y-m-d H:i:s', strtotime($this->created_at)) : null,
            'updated_at' => $this->updated_at ? date('Y-m-d H:i:s', strtotime($this->updated_at)) : null,
        ];
    }
}
