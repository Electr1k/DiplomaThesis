<?php

namespace App\Service;

use App\Models\User;
use App\Repositories\UserRepository;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository){}

    public function store(array $data): User
    {
        return $this->userRepository->store($data);
    }

    public function update(array $data, User $user): User
    {
        return $this->userRepository->update($data, $user);
    }

    public function destroy(User $role): ?bool
    {

        return $this->userRepository->destroy($role);
    }

}
