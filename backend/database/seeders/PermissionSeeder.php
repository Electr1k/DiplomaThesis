<?php

namespace Database\Seeders;

use App\Models\Enums\Permissions\PermissionPermissions;
use App\Models\Enums\Permissions\RolePermissions;
use App\Models\Enums\Permissions\UserPermissions;
use App\Models\Enums\Section\SectionSlug;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            SectionSlug::USERS->value => UserPermissions::cases(),
            SectionSlug::ROLES->value => RolePermissions::cases(),
            SectionSlug::PERMISSIONS->value => PermissionPermissions::cases(),
        ];

        $guardName = config('auth.defaults.guard');

        foreach ($data as $key => $value) {
            $section = Section::query()->firstWhere('slug', $key);
            if (empty($section)) {
                continue;
            }
            $this->permissionsCreate($value, $guardName);
        }

    }

    public function permissionsCreate(array $permissions, string $guardName): void
    {
        foreach ($permissions as $permission) {

            Permission::query()->updateOrCreate([
                'name' => $permission->value,
                'guard_name' => $guardName,
            ]);
        }
    }
}
