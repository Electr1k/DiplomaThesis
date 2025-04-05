<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SummaryReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = match ($request['group'] ?? null) {
            default => $this->date % 100 . ' неделя ' . intdiv($this->date, 100)
        };

        return [
            'date' => $date,
            'orders_count' => $this->orders_count,
            'active_courier_count' => $this->active_courier_count,
            'new_courier_count' => $this->new_courier_count,
            'orders_amount' => round((float) $this->orders_amount, 2) . " ₽",
            'bonus_amount' => round((float) $this->bonus_amount, 2) . " ₽",
            'fine_amount' => round((float) $this->fine_amount, 2)  . " ₽",
        ];
    }
}
