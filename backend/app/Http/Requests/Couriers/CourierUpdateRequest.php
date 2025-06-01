<?php

namespace App\Http\Requests\Couriers;

use App\Models\Enums\Couriers\Citizenship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request для обновления регистрации (сотрудником)
 */
class CourierUpdateRequest extends FormRequest
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
            'courier_partner_id' => ['nullable', 'integer', 'exists:cabinets,courier_partner_id'],
            'phone' => ['nullable', 'string', 'digits:11', 'unique:courier_registrations,phone'],
            'email' => ['nullable', 'email', 'unique:courier_registrations,email'],
            'name' => ['nullable', 'string', 'max:255', 'min:2'],
            'surname' => ['nullable', 'string', 'max:255', 'min:2'],
            'middle_name' => ['nullable', 'string', 'max:255', 'min:2'],
            'date_of_birth' => ['nullable', 'date', 'date_format:Y-m-d'],
            'citizenship' => ['nullable', 'string', Rule::enum(Citizenship::class)],
            'passport_number' => ['nullable', 'string', 'size:10', 'unique:courier_registrations,passport_number'],
        ];
    }
}
