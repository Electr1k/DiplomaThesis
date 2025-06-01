<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verify\VerifyPhoneRequest;
use App\Models\VerifyPhone;
use App\Service\SMSAeroClients\SMSAeroClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;


/**
 * Контроллер для верификации номера телефона
 */
class VerifyController extends Controller
{

    /**
     * Отправка СМС по номеру
     */
    public function verifyPhone(VerifyPhoneRequest $request, SMSAeroClient $client): JsonResponse
    {
        $phone = $request->validated()['phone'];

        $verifyBuilder = VerifyPhone::query()
            ->where('ip', $request->ip());

        $countVerify = $verifyBuilder
            ->where('created_at', '>=', now()->subMinutes(15))
            ->count();

        if ($countVerify >= 3) {
            throw new UnprocessableEntityHttpException('Превышено количество номеров для проверки');
        }

        $canVerify = ! $verifyBuilder
            ->where('phone', $phone)
            ->where('updated_at', '>=', now()->subMinute())
            ->exists();

        if (! $canVerify){
            throw new UnprocessableEntityHttpException('Слишком много попыток отправки');
        }

        $code = rand(1000, 9999);

        VerifyPhone::query()
            ->updateOrCreate(['phone' => $phone, 'ip' => $request->ip()], ['code' => $code]);

        try {
            $client->sendSms($phone, $code);

            return response()->json(['status' => true]);
        }
        catch (Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => false]);
        }
    }

}
