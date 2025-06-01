<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request для создания роли
 */
class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Метод с правилами валидации полей
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'string', 'exists:permissions,code'],
        ];
    }
}
