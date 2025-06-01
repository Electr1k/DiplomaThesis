<?php

namespace App\Service;

use App\Models\Enums\DateTimeMarkType;
use App\Repositories\DateTimeMarkRepository;
use App\Repositories\OrdersRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Carbon\Carbon;

/**
 * Сервис для заказов
 */
readonly class OrderService
{

    public function __construct(
        private OrdersRepository $ordersRepository,
        private DateTimeMarkRepository $dateTimeMarkRepository,
        private DostavistaClient $dostavistaClient
    ){}

    /** Импортировать заказы из Достависта */
    public function fetch(): void
    {
        $to = Carbon::now();
        $from = $this->dateTimeMarkRepository->getLastImportOrdersDateTimeMark()?->date_time;

        if (! $from) {
            $from = Carbon::now()->subHour();
        }

        $nextPageId = null;
        do {
            $data = $this->dostavistaClient->fetchOrders(new Carbon($from), $to, $nextPageId);

            foreach ($data['orders'] as $order) {
                $this->ordersRepository->store($order);
            }

            $this->dateTimeMarkRepository->upsert(
                DateTimeMarkType::LAST_IMPORT_ORDERS,
                $to
            );

            $nextPageId = $data['next_page_id'];

        }while ($nextPageId);
    }
}
