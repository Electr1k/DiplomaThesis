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
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_ORDERS->value)->first();
    }

    public function getLastImportTransactionsDateTimeMark(): ?DateTimeMark
    {
        return DateTimeMark::query()->where('type', DateTimeMarkType::LAST_IMPORT_TRANSACTIONS->value)->first();
    }

    public function upsert(
        DateTimeMarkType $type,
        Carbon $dateTime,
    ): DateTimeMark
    {
        return DateTimeMark::query()->updateOrCreate(['type' => $type->value], ['type' => $type->value, 'date_time' => $dateTime]);
    }
}
