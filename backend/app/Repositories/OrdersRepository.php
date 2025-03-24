<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrdersRepository
{
    /**
     * @return Collection<int, Order>
     */
    public function getAll(): Collection
    {
        return Order::all();
    }

    /**
     * @param array $data
     * @return Order
     */
    public function store(array $data): Order
    {
        return Order::query()->updateOrCreate(['order_id' => $data['order_id']], $data);
    }
}
