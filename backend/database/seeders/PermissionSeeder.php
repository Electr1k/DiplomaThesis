<?php

namespace Database\Seeders;

use App\Models\Enums\Permissions\CabinetPermissions;
use App\Models\Enums\Permissions\CourierPermissions;
use App\Models\Enums\Permissions\DashboardPermissions;
use App\Models\Enums\Permissions\PermissionPermissions;
use App\Models\Enums\Permissions\ReportPermissions;
use App\Models\Enums\Permissions\RolePermissions;
use App\Models\Enums\Permissions\UserPermissions;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            CabinetPermissions::class,
            CourierPermissions::class,
            PermissionPermissions::class,
            RolePermissions::class,
            UserPermissions::class,
            DashboardPermissions::class,
            ReportPermissions::class,
        ];

        foreach ($sections as $section) {
            $this->permissionsCreate($section::cases());
        }
    }

    public function permissionsCreate(array $permissions): void
    {
        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(
                [ 'code' => $permission->value ],
                [ 'name' => $permission->title() ]
            );
        }
    }
}
