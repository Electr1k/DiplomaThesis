<?php

namespace App\Models\Enums\Orders;

enum OrderStatus: string
{
    // Курьер снят
    case ABANDONED = 'abandoned';

    // Заказ отменен
    case CANCELED = 'canceled';

    // Заказ выполнен
    case COMPLETED = 'completed';
}
