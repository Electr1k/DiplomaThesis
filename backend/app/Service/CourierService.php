<?php

namespace App\Service;

use App\Jobs\CreateCourierJob;
use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatus;
use App\Repositories\CourierRegistrationRepository;
use App\Repositories\CourierRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Exception;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;

readonly class CourierService
{

    public function __construct(
        private CourierRepository $courierRepository,
        private CourierRegistrationRepository $courierRegistrationRepository,
        private DostavistaClient $cabinetService,
    ){}

    public function index(array $params): Collection
    {
        return $this->courierRepository->getAll($params);
    }

    public function indexInactive(array $params): Collection
    {
        return $this->courierRepository->getInactive($params);
    }

    public function store(array $data): void
    {
        $currentUser = null;
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $currentUser = $payload->get('sub');
        }
        catch(Exception $e){}

        $courier = $this->courierRegistrationRepository->store([...$data, 'user_id' => $currentUser]);

        // Вызов в джобе (асинхронно)
        CreateCourierJob::dispatch($courier);
    }

    public function fetch(): void
    {
        $couriers = $this->cabinetService->fetchCouriers();

        foreach ($couriers['couriers'] as $courier) {
            $this->courierRepository->store($courier);
        }
    }

    public function updateRegistration(CourierRegistration $registration, array $data): CourierRegistration
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $currentUser = $payload->get('sub');

        $registration->update([...$data, 'user_id' => $currentUser]);
        $registration->status = CourierRegistrationStatus::NEW;
        $registration->save();

        // Вызов в джобе (асинхронно)
        CreateCourierJob::dispatch($registration);

        return $registration;
    }
}
