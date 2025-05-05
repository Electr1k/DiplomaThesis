<?php

namespace App\Models\Enums\Couriers;

use App\Models\Enums\Permissions\HasTitle;

enum CourierRegistrationStatus: string implements HasTitle
{
    // Клиент добавлен в систему и ожидает создание в Достависто
    case NEW = 'new';

    // Клиент успешно создан в Достависто
    case CREATED = 'created';

    // Ошибка при создании в Достависто
    case FAILED = 'failed';

    // Ожидает подтверждения
    case WAITING = 'waiting';


    public function title(): string
    {
        return match ($this) {
            self::NEW => 'Ожидает создания',
            self::CREATED => 'Успешно создан',
            self::FAILED => 'Ошибка',
            self::WAITING => 'Ожидает подтверждения'
        };
    }
}
