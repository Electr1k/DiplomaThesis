<?php

namespace App\Repositories;

use App\Models\CourierRegistration;
use Illuminate\Support\Collection;

class CourierRegistrationRepository
{
    /**
     * @return Collection<int, CourierRegistration>
     */
    public function getAll(): Collection
    {
        return CourierRegistration::all();
    }

    /**
     * @param array $data
     * @return CourierRegistration
     */
    public function store(array $data): CourierRegistration
    {
        return CourierRegistration::query()->updateOrCreate(['phone' => $data['phone']], $data);
    }

    public function update()
    {

    }
}
