<?php

namespace App\Console\Commands;

use App\Service\CabinetService;
use App\Service\CourierService;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Console\Command;

class testCommand extends Command
{
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch couriers partners from Dostavista API';

    public function handle(DostavistaClient $client): void
    {
        $a = $client->storeCourier([
            'fsdfs' => 'fsdf'
        ]);

        dd($a);
    }
}
