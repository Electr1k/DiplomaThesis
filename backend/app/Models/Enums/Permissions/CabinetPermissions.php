<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum CabinetPermissions: string
{
    case READ = 'couriers-read';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр кабинетов',
        };
    }
}
