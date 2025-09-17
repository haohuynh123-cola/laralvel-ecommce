<?php

namespace App\Services;

use App\Contracts\Service\UserServiceInterface;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function listUsers(array $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getListUser($query, $perPage);
    }

    public function updatePassword(int|string|Model $userOrId, string $newPassword): Model
    {
        return $this->repository->update($userOrId, ['password' => $newPassword]);
    }

    public function createUser(array $data): \App\Models\User
    {
        /** @var \App\Models\User $user */
        $user = $this->create($data);
        return $user;
    }

    public function updateUser(int $userId, array $data): \App\Models\User
    {
        /** @var \App\Models\User $user */
        $user = $this->update($userId, $data);
        return $user;
    }

    public function deleteUser(int $userId): void
    {
        $this->delete($userId);
    }

    public function changePassword(int $userId, string $newPassword): void
    {
        $this->updatePassword($userId, $newPassword);
    }
}
