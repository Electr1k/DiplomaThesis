<?php

namespace App\Jobs;

use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatus;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

/**
 * Джоба для создания курьера в "Достависта"
 */
class CreateCourierJob implements ShouldQueue
{
    use Queueable;


    public function __construct(private readonly CourierRegistration $courier){}


    /**
     * Метод с действием при вызове
     */
    public function handle(DostavistaClient $dostavistaClient): void
    {
        $result = [];
        $exceptionMessage = null;
        try {
            $result = $dostavistaClient->storeCourier($this->courier->toArray());
        }
        catch (RequestException $e) {
            Log::info($e->response->json());
            $exceptionMessage = array_keys($e->response->json()['parameter_errors'] ?? []);
            $exceptionMessage = isEmpty($exceptionMessage) ?
                'Неизвестная ошибка' :
                'Ошибки в полях: ' . implode(', ', $exceptionMessage);
        }

        $this->courier->status = ! ($result['is_successful'] ?? null) ? CourierRegistrationStatus::FAILED : CourierRegistrationStatus::CREATED;
        $this->courier->courier_id = $result['courier']['courier_id'] ?? null;
        $this->courier->error_message = $exceptionMessage;
        $this->courier->save();
    }
}
