<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::query()->updateOrCreate([ 'name' => 'Главный админ' ]);

        $role->permissions()->sync(Permission::all()->pluck('code')->toArray());
    }

}
