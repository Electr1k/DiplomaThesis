<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CabinetResource;
use App\Models\Cabinet;
use App\Repositories\CabinetRepository;
use App\Service\CabinetService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CabinetController extends Controller
{

    public function __construct(private CabinetService $service)
    {}

    /**
     * Получение всех кабинетов.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return CabinetResource::collection($this->service->index($request->query()));
    }

    /**
     * Получение выбранного кабинета.
     */
    public function show(Cabinet $cabinet): CabinetResource
    {
        return new CabinetResource($cabinet);
    }

}
