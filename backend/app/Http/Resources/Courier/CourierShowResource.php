<?php

namespace App\Http\Resources\Courier;

use App\Models\Courier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для одного курьера
 * @mixin Courier
 */
class CourierShowResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
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
            'phone' => $this->phone,
            'registered_datetime' => Carbon::parse($this->registered_datetime)->format('d.m.Y'),
            'updated_datetime' => $this->updated_datetime,
            'orders_completed_count' => $this->orders_completed_count,
            'first_order_datetime' => Carbon::parse($this->first_order_datetime)->format('d.m.Y'),
            'last_order_datetime' => Carbon::parse($this->last_order_datetime)->format('d.m.Y'),
            'sum_orders' => round($this->getSumOrders(), 2)  . " ₽",
            'sum_bonus' => round($this->getSumBonus(), 2)  . " ₽",
            'sum_fine' => round($this->getSumFine(), 2)  . " ₽",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

}
