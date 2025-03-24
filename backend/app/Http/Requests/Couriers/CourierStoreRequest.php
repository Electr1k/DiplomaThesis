<?php

namespace App\Http\Requests\Couriers;

use App\Models\Enums\Couriers\Citizenship;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourierStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'courier_partner_id' => ['required', 'integer', 'exists:cabinets,courier_partner_id'],
            'phone' => ['required', 'string', 'phone:RU', 'unique:couriers,phone'],
            'email' => ['nullable', 'email', 'unique:couriers,email'],
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'surname' => ['required', 'string', 'max:255', 'min:2'],
            'middlename' => ['nullable', 'string', 'max:255', 'min:2'],
            'date_of_birth' => ['nullable', 'date', 'date_format:Y-m-d'],
            'citizenship' => ['required', 'string', Rule::enum(Citizenship::class)],
            'passport_number' => ['nullable', 'string', 'length:10', 'unique:couriers,passport_number'],
        ];
    }
}
