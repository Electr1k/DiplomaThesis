<?php

namespace App\Http\Requests\Verify;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request для обновления пользователя (сотрудника)
 */
class VerifyPhoneRequest extends FormRequest
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
            'phone' => ['required', 'regex:/^(7|8)\d{10}$/'],
        ];
    }
}
