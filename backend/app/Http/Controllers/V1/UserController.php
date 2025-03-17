<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
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

}
