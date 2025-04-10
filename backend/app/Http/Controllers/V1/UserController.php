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
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function __construct(private readonly UserService $userService){}

    /**
     * Получение всех пользователей.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->index($request->query()));
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
            $payload = JWTAuth::parseToken()->getPayload();
            $userId = $payload->get('sub');

            if (!$user = User::find($userId)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Пользователь не найден'
                ], 404);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Токен истек'
            ], 401);

        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Неверный токен'
            ], 401);

        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Токен отсутствует'
            ], 401);
        }

        return new UserResource($user);
    }
}
