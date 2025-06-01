<?php

namespace App\Http\Resources;

use App\Models\CourierRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для регистрации
 * @mixin CourierRegistration
 */
class CourierRegistrationResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'courier_id' => $this->courier_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'middle_name' => $this->middle_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'citizenship' => $this->citizenship,
            'passport_number' => $this->passport_number,
            'status' => $this->status->title(),
            'status_code' => $this->status->value,
            'user' => $this->user ? new UserResource($this->user) : null,
            'error_message' => $this->error_message,
            'errors' => array_keys(json_decode($this->error_message, true) ?? []) ?? $this->error_message,
            'cabinet' => new CabinetResource($this->cabinet),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y H:i')
        ];
    }
}
