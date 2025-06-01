<?php

namespace App\Repositories;

use App\Models\Order;

/**
 * Репозиторий для заказов
 */
class OrdersRepository
{

    /**
     * Создание заказа в БД
     */
    public function store(array $data): Order
    {
        return Order::query()->updateOrCreate(['order_id' => $data['order_id']], $data);
    }
}
