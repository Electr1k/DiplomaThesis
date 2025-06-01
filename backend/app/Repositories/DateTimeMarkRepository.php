<?php

namespace App\Repositories;

use App\Models\DateTimeMark;
use App\Models\Enums\DateTimeMarkType;
use App\Models\Order;
use Carbon\Carbon;

/**
 * Репозиторий для временных меток
 */
class DateTimeMarkRepository
{
    /**
     * Получение временной метки последнего заказа
     */
    public function getLastImportOrdersDateTimeMark(): ?DateTimeMark
    {
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_ORDERS->value)->first();
    }

    /**
     * Получение временной метки последней транзакции
     */
    public function getLastImportTransactionsDateTimeMark(): ?DateTimeMark
    {
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_TRANSACTIONS->value)->first();
    }

    /**
     * Обновление временной метки
     */
    public function upsert(
        DateTimeMarkType $type,
        Carbon $dateTime,
    ): DateTimeMark
    {
        return DateTimeMark::query()->updateOrCreate(['type' => $type->value], ['type' => $type->value, 'date_time' => $dateTime]);
    }
}
