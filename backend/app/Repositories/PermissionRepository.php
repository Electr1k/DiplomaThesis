<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Support\Collection;

class PermissionRepository
{
    /**
     * @return Collection<int, Permission>
     */
    public function getAll(): Collection
    {
        return Permission::all();
    }

}
