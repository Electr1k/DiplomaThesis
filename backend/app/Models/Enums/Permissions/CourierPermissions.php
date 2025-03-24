<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum CourierPermissions: string
{
    case READ = 'couriers-read';
    case STORE = 'couriers-store';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр курьеров',
            self::STORE => 'Создание курьеров',
        };
    }
}
