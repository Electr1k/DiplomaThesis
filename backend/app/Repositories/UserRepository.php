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

}
