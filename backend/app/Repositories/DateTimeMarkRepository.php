<?php

namespace App\Repositories;

use App\Models\DateTimeMark;
use App\Models\Enums\DateTimeMarkType;
use App\Models\Order;
use Carbon\Carbon;

class DateTimeMarkRepository
{
    public function getLastImportOrdersDateTimeMark(): ?DateTimeMark
    {
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_ORDERS)->first();
    }

    public function getLastImportTransactionsDateTimeMark(): ?DateTimeMark
    {
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_TRANSACTIONS)->first();
    }

    public function upsert(
        DateTimeMarkType $type,
        Carbon $dateTime,
    ): Order
    {
        return Order::query()->updateOrCreate(['type' => $type], ['type' => $type, 'date_time' => $dateTime]);
    }
}
