<?php

namespace App\Models\Enums\Couriers;

enum Citizenship: string
{
    // Гражданин страны
    case DOMESTIC = 'domestic';

    // Иностранный гражданин
    case FOREIGN = 'foreign';

    // Нет данных
    case UNKNOWN = 'unknown';
}
