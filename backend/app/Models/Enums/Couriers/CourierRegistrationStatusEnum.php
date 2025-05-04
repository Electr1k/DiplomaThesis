<?php

namespace App\Models\Enums\Couriers;

use App\Models\Enums\Permissions\HasTitle;

enum CourierRegistrationStatusEnum: string implements HasTitle
{
    // Клиент добавлен в систему и ожидает создание в Достависто
    case NEW = 'new';

    // Клиент успешно создан в Достависто
    case CREATED = 'created';

    // Ошибка при создаии в Достависто
    case FAILED = 'failed';


    public function title(): string
    {
        return match ($this) {
            self::NEW => 'Новая',
            self::CREATED => 'Успешно создан',
            self::FAILED => 'Ошибка',
        };
    }
}
