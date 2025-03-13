<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum RolePermissions: string
{
    case READ = 'roles-read';
    case STORE = 'roles-store';
    case UPDATE = 'roles-update';
    case DESTROY = 'roles-destroy';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр ролей',
            self::STORE => 'Добавление ролей',
            self::UPDATE => 'Редактирование ролей',
            self::DESTROY => 'Удаление ролей',
        };
    }
}
