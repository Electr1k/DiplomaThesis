<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RoleRepository
{
    /**
     * @return Collection<int, Role>
     */
    public function getAll(array $params): Collection
    {
        return Role::query()
            ->when(isset($params['search']), function (Builder $query) use ($params) {
                $query->where('name', 'ILIKE', '%'.$params['search'].'%');
            })
            ->get();
    }

    /**
     * @param array $data
     * @return Role
     */
    public function store(array $data): Role
    {
        $role = Role::query()->create([
            'name' => $data['name'],
        ]);
        $role->permissions()->sync($data['permissions']);
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

        $role->permissions()?->sync($data['permissions']);
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
