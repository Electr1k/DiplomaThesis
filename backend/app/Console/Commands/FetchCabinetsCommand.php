<?php

namespace App\Console\Commands;

use App\Service\CabinetService;
use Illuminate\Console\Command;

class FetchCabinetsCommand extends Command
{
    protected $signature = 'app:fetch-cabinets-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch cabinets partners from Dostavista API';

    public function handle(CabinetService $cabinetService): void
    {
        $cabinetService->fetch();
    }
}
