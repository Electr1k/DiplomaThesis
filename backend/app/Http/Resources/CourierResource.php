<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'courier_id' => $this->courier_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'middle_name' => $this->middle_name,
            'status' => $this->status,
            'ban_end_datetime' => $this->ban_end_datetime,
            'phone' => $this->phone,
            'registered_datetime' => $this->registered_datetime,
            'updated_datetime' => $this->updated_datetime,
            'orders_completed_count' => $this->orders_completed_count,
            'first_order_datetime' => $this->first_order_datetime,
            'last_order_datetime' => $this->last_order_datetime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
