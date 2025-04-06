<?php

namespace App\Repositories;

use App\Models\Courier;
use Illuminate\Support\Collection;

class CourierRepository
{
    /**
     * @return Collection<int, Courier>
     */
    public function getAll(): Collection
    {
        return Courier::all();
    }

    /**
     * @return Collection<int, Courier>
     */
    public function getInactive(): Collection
    {
        return Courier::query()
            ->where('last_order_datetime', '<=', now()->subDays(14))
            ->orderByDesc('last_order_datetime')
            ->get();
    }

    /**
     * @param array $data
     * @return Courier
     */
    public function store(array $data): Courier
    {
        return Courier::query()->updateOrCreate(['phone' => $data['phone']], $data);
    }
}
