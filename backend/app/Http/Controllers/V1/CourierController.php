<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Http\Resources\CourierResource;
use App\Models\User;
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
    public function show(User $user): CourierResource
    {
        return new CourierResource($user);
    }

    /**
     * Создание курьера.
     */
    public function store(CourierStoreRequest $courier): JsonResponse
    {
        $this->courierService->store($courier->validated());

        return response()->json(['message' => 'Courier successfully created'], 201);
    }

}
