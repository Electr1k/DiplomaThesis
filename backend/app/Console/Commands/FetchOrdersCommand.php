<?php

namespace App\Console\Commands;

use App\Service\OrderService;
use Illuminate\Console\Command;

/**
 * Команда для импорта заказов
 */
class FetchOrdersCommand extends Command
{
    protected $signature = 'app:fetch-orders-command';

    protected $description = 'Fetch orders from Dostavista API';

    public function handle(OrderService $orderService): void
    {
        $orderService->fetch();
    }
}
