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

    public function index(array $params): Collection
    {
        return $this->cabinetRepository->getAll($params);
    }

    public function fetch(): void
    {
       $cabinets = $this->dostavistaClient->fetchCabinet();

        foreach ($cabinets['courier_partners'] as $cabinet) {
            $this->cabinetRepository->store($cabinet);
        }
    }
}
