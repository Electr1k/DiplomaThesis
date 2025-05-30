<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum PermissionPermissions: string implements HasTitle
{
    case READ = 'permissions-read';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр разрешений',
        };
    }
}
