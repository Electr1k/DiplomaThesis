<?php

namespace App\Http\Resources;

use App\Models\Cabinet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * JSON ресурс для кабинета
 * @mixin Cabinet
 */
class CabinetResource extends JsonResource
{
    /**
     * Переобпределяемый метод с полями, которые должны быть в response
     */
    public function toArray(Request $request): array
    {
        return [
            'courier_partner_id' => $this->courier_partner_id,
            'region_name' => $this->region_name,
            'vehicle_type_name' => $this->vehicle_type_name,
            'legal_name' => $this->legal_name,
            'partner_commission_part' => $this->partner_commission_part,
            'is_for_taking_available_couriers' => $this->is_for_taking_available_couriers,
        ];
    }
}
