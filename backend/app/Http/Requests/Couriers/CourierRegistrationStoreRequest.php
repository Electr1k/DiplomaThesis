<?php

namespace App\Http\Requests\Couriers;

use App\Models\Enums\Couriers\Citizenship;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourierRegistrationStoreRequest extends FormRequest
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
            'phone' => ['required', 'string', 'digits:11', 'unique:courier_registrations,phone'],
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'surname' => ['required', 'string', 'max:255', 'min:2'],
            'middle_name' => ['nullable', 'string', 'max:255', 'min:2'],
            'citizenship' => ['required', 'string', Rule::enum(Citizenship::class)],
            'code' => ['required', 'string', 'size:4'],
        ];
    }
}
