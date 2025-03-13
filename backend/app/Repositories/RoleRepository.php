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

}
