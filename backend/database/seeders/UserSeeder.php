<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailDefaultUser = Config::get('auth.default_user.email');
        $superAdminRole = Role::query()->where('name', 'Главный админ')->firstOrFail();

        $superAdminUser = User::query()->where('email', $emailDefaultUser)->first();
        if (! $superAdminUser) {
            User::query()->create([
                'name' => 'Админ',
                'surname' => 'Админов',
                'email' => $emailDefaultUser,
                'role_id' => $superAdminRole->id,
                'password' => Hash::make('password'),
            ]);
        }
    }

}
