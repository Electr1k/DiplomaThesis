<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Couriers\CourierRegistrationStoreRequest;
use App\Http\Requests\Couriers\CourierStoreRequest;
use App\Http\Requests\Couriers\CourierUpdateRequest;
use App\Http\Resources\Courier\CourierIndexResource;
use App\Http\Resources\Courier\CourierShowResource;
use App\Http\Resources\CourierRegistrationResource;
use App\Models\Courier;
use App\Models\CourierRegistration;
use App\Models\Enums\Couriers\CourierRegistrationStatus;
use App\Models\VerifyPhone;
use App\Repositories\CourierRegistrationRepository;
use App\Service\CourierService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
     * Создание заявки для регистрации курьера.
     */
    public function storeRegistrationTicket(CourierRegistrationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $verifyBuilder = VerifyPhone::query()->where('phone', $data['phone'])
            ->where('updated_at', '>=', now()->subMinutes(15));

        $existVerify = (clone $verifyBuilder)->exists();

        if (! $existVerify) {
            throw new UnprocessableEntityHttpException('Номер не подтвержден');
        }

        $existVerify = (clone $verifyBuilder)->where('code', $data['code'])->exists();

        if (! $existVerify) {
            $verify = $verifyBuilder
                ->orderByDesc('created_at')
                ->first();

            $verify->attempts++;
            $verify->save();

            throw new UnprocessableEntityHttpException('Неверный код');
        }

        $registration = CourierRegistration::query()->create($data);
        $registration->status = CourierRegistrationStatus::WAITING;
        $registration->save();

        return response()->json(['message' => 'Courier successfully registered'], 201);
    }

    /**
     * Отклонение заявки для регистрации курьера.
     */
    public function closeRegistrationTicket(CourierRegistration $registration): CourierRegistrationResource
    {
        $currentUser = null;
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $currentUser = $payload->get('sub');
        }
        catch(Exception $e){}

        $registration->status = CourierRegistrationStatus::CLOSED;
        $registration->user_id = $currentUser;
        $registration->save();

        return new CourierRegistrationResource($registration);
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
        $registration = $this->courierService->updateRegistration($registration, $courier->validated());

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
