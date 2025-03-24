<?php

namespace App\Service;

use App\Repositories\CabinetRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Illuminate\Support\Collection;

readonly class CabinetService
{

    public function __construct(
        private CabinetRepository $cabinetRepository,
        private DostavistaClient $dostavistaClient
    ){}

    public function getAll(): Collection
    {
        return $this->cabinetRepository->getAll();
    }

    public function fetch(): void
    {
       $cabinets = $this->dostavistaClient->fetchCabinet();

        foreach ($cabinets['courier_partners'] as $cabinet) {
            $this->cabinetRepository->store($cabinet);
        }
    }
}
