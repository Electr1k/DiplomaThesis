<?php

namespace Database\Seeders;

use App\Models\Enums\User\Gender;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::query()->where('name', config('permission.super_admin.role_name'))->firstOrFail();
        $emailDefaultUser = Config::get('auth.default_user.email');

        $superAdminUser = User::query()->where('email', $emailDefaultUser)->first();
        if (! $superAdminUser) {
            $superAdminUser = User::query()->create([
                'name' => 'Админ',
                'email' => $emailDefaultUser,
                'password' => Hash::make('password'),
            ]);
        }

        $superAdminUser->syncRoles($superAdminRole->name);
    }


}
