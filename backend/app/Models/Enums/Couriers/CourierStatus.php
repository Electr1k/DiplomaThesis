<?php

namespace App\Models\Enums\Couriers;

enum CourierStatus: string
{
    case APPROVED = 'approved';

    public function title(): string
    {
        return match ($this) {
            self::APPROVED => 'Подтвержден'
        };
    }
}
