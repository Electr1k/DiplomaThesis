<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Http\Resources\CourierRegistrationResource;
use App\Http\Resources\CourierResource;
use App\Models\Courier;
use App\Models\CourierRegistration;
use App\Models\User;
use App\Repositories\CourierRegistrationRepository;
use App\Repositories\CourierRepository;
use App\Service\CourierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CourierController extends Controller
{

    public function __construct(private readonly CourierService $courierService){}

    /**
     * Получение всех курьеров.
     */
    public function index(CourierRepository $repository): AnonymousResourceCollection
    {
        return CourierResource::collection($repository->getAll());
    }

    /**
     * Получение выбранного курьера.
     */
    public function show(Courier $courier): CourierResource
    {
        return new CourierResource($courier);
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
    public function registrations(CourierRegistrationRepository $repository): AnonymousResourceCollection
    {
        return CourierRegistrationResource::collection($repository->getAll());
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
    public function registrationUpdate(CourierRegistration $registration, CourierStoreRequest $courier): CourierRegistrationResource
    {
        $registration->update($courier->validated());

        return new CourierRegistrationResource($registration);
    }

    /**
     * Получение неактивных курьеров.
     */
    public function indexInactive(CourierRepository $repository): AnonymousResourceCollection
    {
        return CourierResource::collection($repository->getInactive());
    }
}
