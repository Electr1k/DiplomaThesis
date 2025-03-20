<?php

namespace App\Service;

use App\Models\Courier;
use App\Repositories\CabinetRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Support\Collection;

readonly class CourierService
{

    public function __construct(
        private CabinetRepository $cabinetRepository,
    ){}

    public function getAll(): Collection
    {
        return $this->cabinetRepository->getAll();
    }

    public function store(array $data): void
    {
        $courier = Courier::query()->create($data);

        // Вызов в джобе
        CreateCourierJob::dispatch($courier);
    }
}
