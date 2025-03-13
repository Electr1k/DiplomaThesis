<?php

declare(strict_types=1);

namespace App\Models\Enums\Permissions;


enum UserPermissions: string
{
    case READ = 'users-read';
    case STORE = 'users-store';
    case UPDATE = 'users-update';
    case DESTROY = 'users-destroy';

    public function title(): string
    {
        return match ($this) {
            self::READ => 'Просмотр сотрудников',
            self::STORE => 'Добавление сотрудников',
            self::UPDATE => 'Редактирование сотрудников',
            self::DESTROY => 'Удаление сотрудников',
        };
    }
}
