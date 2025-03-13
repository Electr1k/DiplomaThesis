<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    /**
     * Получение всех ролей.
     */
    public function index(RoleRepository $repository): AnonymousResourceCollection
    {
        return RoleResource::collection($repository->getAll());
    }

    /**
     * Получение выбранной роли.
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role);
    }

}
