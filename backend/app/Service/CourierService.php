<?php

namespace App\Service;

use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Jobs\CreateCourierJob;
use App\Models\Courier;
use App\Repositories\CabinetRepository;
use App\Repositories\CourierRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Support\Collection;

readonly class CourierService
{

    public function __construct(
        private CourierRepository $courierRepository,
        private DostavistaClient $cabinetService,
    ){}

    public function getAll(): Collection
    {
        return $this->courierRepository->getAll();
    }

    public function store(CourierStoreRequest $data): void
    {
        $courier = Courier::query()->create($data->validated());

        // Вызов в джобе
        CreateCourierJob::dispatch($courier);
    }

    public function fetch(array $data): void
    {
        try {
            $couriers = $this->cabinetService->fetchCouriers($data);

            foreach ($couriers as $courier) {
                $this->courierRepository->store($courier);
            }
        }
        catch (\Exception $exception){

        }
    }
}
