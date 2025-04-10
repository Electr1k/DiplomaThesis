<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Service\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{

    public function __construct(protected RoleService $service){}

    /**
     * Получение всех ролей.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return RoleResource::collection($this->service->index($request->query()));
    }

    /**
     * Получение выбранной роли.
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role);
    }

    /**
     * Создание роли.
     */
    public function store(RoleRequest $role): RoleResource
    {
        return new RoleResource($this->service->store($role->validated()));
    }

    /**
     * Обнолвение роли.
     */
    public function update(RoleRequest $request, Role $role): RoleResource
    {
        return new RoleResource($this->service->update($request->validated(), $role));
    }

    /**
     * Удаление роли.
     */
    public function destroy(Role $role): JsonResponse
    {
        return response()->json(['status' => $this->service->destroy($role)]);
    }

}
