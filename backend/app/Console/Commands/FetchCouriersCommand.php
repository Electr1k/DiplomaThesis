<?php

namespace App\Console\Commands;

use App\Service\CabinetService;
use App\Service\CourierService;
use Illuminate\Console\Command;

/**
 * Команда для импорта курьеров
 */
class FetchCouriersCommand extends Command
{
    protected $signature = 'app:fetch-couriers-command';

    protected $description = 'Fetch couriers partners from Dostavista API';

    public function handle(CourierService $courierService): void
    {
        $courierService->fetch();
    }
}
