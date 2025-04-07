<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum CabinetPermissions: string implements HasTitle
{
    case READ = 'cabinets-read';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр кабинетов',
        };
    }
}
