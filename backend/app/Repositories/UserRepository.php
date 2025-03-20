<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    /**
     * @return Collection<int, User>
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * @param array $data
     * @return User
     */
    public function store(array $data): User
    {
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user->assignRole($data['role_id']);

        return $user;
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function update(array $data, User $user): User
    {
        $user->update($data);

        isset($data['role_id']) && $user->assignRole($data['role_id']);

        return $user;
    }

    /**
     * @param User $user
     * @return ?bool
     */
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }

}
