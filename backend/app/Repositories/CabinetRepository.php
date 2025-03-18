<?php

namespace App\Repositories;

use App\Models\Cabinet;
use Illuminate\Support\Collection;

class CabinetRepository
{
    /**
     * @return Collection<int, Cabinet>
     */
    public function getAll(): Collection
    {
        return Cabinet::all();
    }

    /**
     * @param array $data
     * @return Cabinet
     */
    public function store(array $data): Cabinet
    {
        return Cabinet::create($data);
    }
}
