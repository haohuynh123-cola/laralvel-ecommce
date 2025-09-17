<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function paginateWithRequest(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateWithRequest($request, $perPage);
    }

    public function updatePassword(int|string|Model $userOrId, string $newPassword): Model
    {
        return $this->repository->update($userOrId, ['password' => $newPassword]);
    }
}
