<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function __construct(private readonly UserService $userService){}

    /**
     * Получение всех пользователей.
     */
    public function index(UserRepository $repository): AnonymousResourceCollection
    {
        return UserResource::collection($repository->getAll());
    }

    /**
     * Получение выбранного пользователя.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Создание пользователя.
     */
    public function store(UserStoreRequest $role): UserResource
    {
        return new UserResource($this->userService->store($role->validated()));
    }

    /**
     * Обнолвение пользователя.
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        return new UserResource($this->userService->update($request->validated(), $user));
    }

    /**
     * Удаление пользователя.
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json(['status' => $this->userService->destroy($user)]);
    }

    public function getUserByToken(): UserResource|JsonResponse
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404);
            }

        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 401);
        }

        // Успешная аутентификация - возвращаем данные пользователя
        return new UserResource($user);
    }
}
