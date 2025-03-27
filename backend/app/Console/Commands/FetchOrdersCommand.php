<?php

namespace App\Console\Commands;

use App\Service\OrderService;
use Illuminate\Console\Command;

class FetchOrdersCommand extends Command
{
    protected $signature = 'app:fetch-orders-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch orders from Dostavista API';

    public function handle(OrderService $orderService): void
    {
        $orderService->fetch();
    }
}
