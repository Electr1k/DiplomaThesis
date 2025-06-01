<?php

namespace App\Service\Report;

use App\Models\Enums\Transactions\TransactionStatus;
use App\Models\Enums\Transactions\TransactionType;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Сервис для сводного отчета
 */
class SummaryService
{

    /** Метод для получения сводного отчета */
    public function index(array $data): array
    {
        $group = $data['group'] ?? null;

        $toDate = match ($group) {
            'year' => fn (string $dateColumn) => "to_char($dateColumn, 'YYYYMM')::integer",
            'month' => fn (string $dateColumn) => "$dateColumn::date",
            'day' => fn (string $dateColumn) => "EXTRACT(ISOYEAR FROM $dateColumn)::integer",
            default => fn (string $dateColumn) => "to_char($dateColumn, 'IYYYIW')::integer",
        };

        $query = DB::query()
            ->select(
                DB::raw('coalesce(transactions.date, orders.date) as date'),
                'orders_amount',
                'bonus_amount',
                'fine_amount',
                'orders_count',
                'active_courier_count',
                'new_courier_count'
            )
            ->fromSub(
                $this->getTransactionSubQuery($toDate),
                'transactions',
            )
            ->joinSub(
                $this->getOrderSubQuery($toDate),
                'orders', 'transactions.date', '=', 'orders.date', 'full'
            )
            ->orderByDesc('date');

        Log::info($query->toSql());
        return $query->get()->toArray();
    }

    /** Метод для подготовки подзапроса с транзакциями */
    private function getTransactionSubQuery(callable $toDate): Builder
    {
        return Transaction::query()
            ->select(
                DB::raw($toDate('updated_datetime').' as date'),
                DB::raw(
                    "SUM(
                        CASE
                            WHEN transaction_type = '" . TransactionType::ORDER->value . "' THEN amount
                            ELSE 0
                        END
                    ) as orders_amount"),
                DB::raw(
                    "SUM(
                        CASE
                            WHEN transaction_type = '" . TransactionType::BONUS->value . "' THEN amount
                            ELSE 0
                        END
                    ) as bonus_amount"),
                DB::raw(
                    "SUM(
                        CASE
                            WHEN transaction_type = '" . TransactionType::FINE->value . "' THEN amount
                            ELSE 0
                        END
                    ) as fine_amount"),
            )
            ->where('transaction_status', TransactionStatus::ACTIVE->value)
            ->groupBy('date');
    }

    /** Метод для подготовки подзапроса с заказами */
    private function getOrderSubQuery(callable $toDate): Builder
    {
        return Order::query()
            ->select(
                DB::raw($toDate('order_finished_datetime').' as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw("COUNT(DISTINCT orders.courier_id) as active_courier_count"),
                DB::raw(
                    "COUNT(DISTINCT
                        CASE WHEN ".$toDate('couriers.first_order_datetime').' = '.$toDate('orders.order_finished_datetime')."
                            THEN couriers.courier_id
                            ELSE NULL
                        END
                    ) as new_courier_count"),
            )
            ->join('couriers', 'couriers.courier_id', '=', 'orders.courier_id')
            ->groupBy('date');
    }
}
