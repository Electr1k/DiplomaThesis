<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для роли
 * @mixin Role
 */
class RoleResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => PermissionResource::collection($this->permissions)
        ];
    }
}
