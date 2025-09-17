<?php

namespace App\Contracts\Service;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function listUsers(array $criteria, int $perPage = 15): LengthAwarePaginator;

    public function createUser(array $data): User;

    public function updateUser(int $userId, array $data): User;

    public function deleteUser(int $userId): void;

    public function changePassword(int $userId, string $newPassword): void;
}
