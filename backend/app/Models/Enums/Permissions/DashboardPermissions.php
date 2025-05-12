<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum DashboardPermissions: string implements HasTitle
{
    case READ = 'dashboard-read';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр дашбоард статистики',
        };
    }
}
