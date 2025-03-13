<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->updateOrCreate([
            'name' => config('permission.super_admin.role_name'),
            'guard_name' => config('auth.defaults.guard'),
        ], [
            'name' => config('permission.super_admin.role_name'),
        ]);

    }

}
