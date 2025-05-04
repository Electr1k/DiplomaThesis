<?php

namespace App\Jobs;

use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatusEnum;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class CreateCourierJob implements ShouldQueue
{
    use Queueable;


    public function __construct(private readonly CourierRegistration $courier){}


    public function handle(DostavistaClient $dostavistaClient): void
    {
        $result = [];
        $exceptionMessage = null;
        try {
            $result = $dostavistaClient->storeCourier($this->courier->toArray());
        }
        catch (RequestException $e) {
            $exceptionMessage = array_keys($e->response->json()['parameter_errors']) ?? 'Неизвестная ошибка';
        }

        $this->courier->status = ! ($result['is_successful'] ?? null) ? CourierRegistrationStatusEnum::FAILED : CourierRegistrationStatusEnum::CREATED;
        $this->courier->courier_id = $result['courier']['courier_id'] ?? null;
        $this->courier->error_message = $exceptionMessage;
        $this->courier->save();
    }
}
