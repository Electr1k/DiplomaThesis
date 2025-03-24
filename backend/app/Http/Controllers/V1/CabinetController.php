<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Http\Resources\CabinetResource;
use App\Http\Resources\CourierResource;
use App\Models\Cabinet;
use App\Models\User;
use App\Repositories\CabinetRepository;
use App\Repositories\CourierRepository;
use App\Service\CabinetService;
use App\Service\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CabinetController extends Controller
{

    /**
     * Получение всех кабинетов.
     */
    public function index(CabinetRepository $repository): AnonymousResourceCollection
    {
        return CabinetResource::collection($repository->getAll());
    }

    /**
     * Получение выбранного кабинета.
     */
    public function show(Cabinet $cabinet): CabinetResource
    {
        return new CabinetResource($cabinet);
    }

}
