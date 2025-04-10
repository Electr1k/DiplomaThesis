<?php

namespace App\Http\Resources\Courier;

use App\Models\Courier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Courier
 */
class CourierIndexResource extends JsonResource
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
            'status' => $this->status->title(),
            'ban_end_datetime' => $this->ban_end_datetime,
            'phone' => $this->hide_phone($this->phone),
            'registered_datetime' => Carbon::parse($this->registered_datetime)->format('d.m.Y'),
            'updated_datetime' => $this->updated_datetime,
            'orders_completed_count' => $this->orders_completed_count,
            'first_order_datetime' => Carbon::parse($this->first_order_datetime)->format('d.m.Y'),
            'last_order_datetime' => Carbon::parse($this->last_order_datetime)->format('d.m.Y'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    private function hide_phone(string $value): string
    {
        if ($value[0] != '+') {
            $value = '+' . $value;
        }

        if ($value[1] != '8') {
            $value[1] = '7';
        }

        $phoneNumber = $value;
        return substr($value, 0, 2) . '(' .
            substr($phoneNumber, 2, 3) . ')***-**-' .
            substr($phoneNumber, 10, 2);
    }
}
