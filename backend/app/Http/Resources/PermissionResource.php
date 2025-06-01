<?php

namespace App\Http\Resources;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для разрешения
 * @mixin Permission
 */
class PermissionResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
        ];
    }
}
