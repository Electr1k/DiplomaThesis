<?php

namespace App\Service;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class RoleService
{

    public function __construct(private RoleRepository $roleRepository){}

    public function index(array $params): Collection
    {
        return $this->roleRepository->getAll($params);
    }

    public function store(array $data): Role
    {
        return $this->roleRepository->store($data);
    }

    public function update(array $data, Role $role): Role
    {
        return $this->roleRepository->update($data, $role);
    }

    public function destroy(Role $role): ?bool
    {
        if ($role->users()->exists()) {
            throw new UnprocessableEntityHttpException('Role cannot be deleted');
        }

        return $this->roleRepository->destroy($role);
    }
}
