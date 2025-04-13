<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Http\Requests\Couriers\CourierUpdateRequest;
use App\Http\Resources\Courier\CourierIndexResource;
use App\Http\Resources\Courier\CourierShowResource;
use App\Http\Resources\CourierRegistrationResource;
use App\Models\Courier;
use App\Models\CourierRegistration;
use App\Repositories\CourierRegistrationRepository;
use App\Repositories\CourierRepository;
use App\Service\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourierController extends Controller
{

    public function __construct(private readonly CourierService $courierService){}

    /**
     * Получение всех курьеров.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return CourierIndexResource::collection($this->courierService->index($request->query()));
    }

    /**
     * Получение выбранного курьера.
     */
    public function show(Courier $courier): CourierShowResource
    {
        return new CourierShowResource($courier);
    }

    /**
     * Создание курьера.
     */
    public function store(CourierStoreRequest $courier): JsonResponse
    {
        $this->courierService->store($courier->validated());

        return response()->json(['message' => 'Courier successfully created'], 201);
    }


    /**
     * Получение списка регистраций курьеров.
     */
    public function registrations(Request $request, CourierRegistrationRepository $repository): AnonymousResourceCollection
    {
        return CourierRegistrationResource::collection($repository->getAll($request->query()));
    }

    /**
     * Получение выбранной регистрации курьера.
     */
    public function registrationShow(CourierRegistration $registration): CourierRegistrationResource
    {
        return new CourierRegistrationResource($registration);
    }

    /**
     * Обновление данных регистрации курьера.
     */
    public function registrationUpdate(CourierRegistration $registration, CourierUpdateRequest $courier): CourierRegistrationResource
    {
        $registration->update($courier->validated());

        return new CourierRegistrationResource($registration);
    }

    /**
     * Получение неактивных курьеров.
     */
    public function indexInactive(Request $request): AnonymousResourceCollection
    {
        return CourierIndexResource::collection($this->courierService->indexInactive($request->query()));
    }
}
