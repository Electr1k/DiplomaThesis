<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Support\Collection;

/**
 * Репозиторий для разрешений
 */
class PermissionRepository
{
    /**
     * Получение всех разрешений
     * @return Collection<int, Permission>
     */
    public function getAll(): Collection
    {
        return Permission::all();
    }

}
