<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для пользователя
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'middle_name' => $this->middle_name,
            'email' => $this->email,
            'image' => $this->image,
            'role' => new RoleResource($this->role),
            'created_at' => $this->created_at
        ];
    }
}
