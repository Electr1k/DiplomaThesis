<?php

namespace App\Console\Commands;

use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatus;
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
        CourierRegistration::query()->create(['phone' => '1234', "citizenship" => 'domestics', 'status' => CourierRegistrationStatus::WAITING]);

    }
}
