<?php

namespace App\Service;

use App\Jobs\CreateCourierJob;
use App\Repositories\CourierRegistrationRepository;
use App\Repositories\CourierRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Support\Collection;

readonly class CourierService
{

    public function __construct(
        private CourierRepository $courierRepository,
        private CourierRegistrationRepository $courierRegistrationRepository,
        private DostavistaClient $cabinetService,
    ){}

    public function getAll(): Collection
    {
        return $this->courierRepository->getAll();
    }

    public function store(array $data): void
    {
        $courier = $this->courierRegistrationRepository->store($data);

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
}
