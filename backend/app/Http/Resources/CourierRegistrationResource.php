<?php

namespace App\Http\Resources;

use App\Models\CourierRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CourierRegistration */
class CourierRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
            'status' => $this->status,
            'cabinet' => new CabinetResource($this->cabinet),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y')
        ];
    }
}
