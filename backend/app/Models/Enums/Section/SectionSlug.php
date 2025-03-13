<?php

declare(strict_types=1);

namespace App\Models\Enums\Section;


use App\Models\Enums\Permissions\PermissionPermissions;
use App\Models\Enums\Permissions\RolePermissions;
use App\Models\Enums\Permissions\UserPermissions;

enum SectionSlug: string
{
    case USERS = 'users';
    case ROLES = 'roles';
    case PERMISSIONS = 'permissions';

    public function title(): string
    {
        return match ($this) {
            self::USERS => 'sections.users',
            self::ROLES => 'sections.roles',
            self::PERMISSIONS => 'sections.permissions',
        };
    }

    public function permission(string $action): UserPermissions|PermissionPermissions|RolePermissions
    {
        return match ($this) {
            self::USERS => UserPermissions::from("users-$action"),
            self::ROLES => RolePermissions::from("roles-$action"),
            self::PERMISSIONS => PermissionPermissions::from("permissions-$action"),
        };
    }


}
