<?php

namespace App\Jobs;

use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatusEnum;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateCourierJob implements ShouldQueue
{
    use Queueable;


    public function __construct(private readonly CourierRegistration $courier){}


    public function handle(DostavistaClient $dostavistaClient): void
    {
        $result = $dostavistaClient->storeCourier($this->courier->toArray());

        $this->courier->status = ! $result['is_successful'] ? CourierRegistrationStatusEnum::FAILED : CourierRegistrationStatusEnum::CREATED;
        $this->courier->courier_id = $result['courier']['courier_id'] ?? null;
        $this->courier->save();
    }
}
