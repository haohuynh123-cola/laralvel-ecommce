<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $service) {}

    public function index(UserIndexRequest $request): JsonResponse
    {
        $query = $request->validated();
        $paginator = $this->service->listUsers($query, (int) data_get($request, 'per_page', 15));
        $collection = UserResource::collection($paginator->getCollection());
        return response()->json(
            PaginatedResource::make($collection, $paginator, $request)
        );
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->service->create($request->validated());
        return response()->json(new UserResource($user), 201);
    }

    public function show(int $user): JsonResponse
    {
        $model = $this->service->findOrFail($user);
        return response()->json(new UserResource($model));
    }

    public function update(UserUpdateRequest $request, int $user): JsonResponse
    {
        $model = $this->service->update($user, $request->validated());
        return response()->json(new UserResource($model));
    }

    public function destroy(int $user): JsonResponse
    {
        $this->service->delete($user);
        return response()->json([], 204);
    }
}
