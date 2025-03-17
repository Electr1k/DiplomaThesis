<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Support\Collection;

class RoleRepository
{
    /**
     * @return Collection<int, Role>
     */
    public function getAll(): Collection
    {
        return Role::all();
    }

    /**
     * @param array $data
     * @return Role
     */
    public function store(array $data): Role
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'web'
        ]);
        $role->syncPermissions($data['permissions']);
        return $role;
    }


    /**
     * @param array $data
     * @param Role $role
     * @return Role
     */
    public function update(array $data, Role $role): Role
    {
        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions']);
        return $role;
    }

    /**
     * @param Role $role
     * @return ?bool
     */
    public function destroy(Role $role): ?bool
    {
        return $role->delete();
    }

}
