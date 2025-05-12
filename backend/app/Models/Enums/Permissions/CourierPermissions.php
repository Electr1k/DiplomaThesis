<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum CourierPermissions: string implements HasTitle
{
    case READ = 'couriers-read';
    case STORE = 'couriers-store';
    case UPDATE = 'couriers-update';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр курьеров',
            self::STORE => 'Создание курьеров',
            self::UPDATE => 'Обновление регистрации',
        };
    }
}
