<?php

namespace App\Service;

use App\Models\Enums\DateTimeMarkType;
use App\Repositories\DateTimeMarkRepository;
use App\Repositories\TransactionsRepository;
use App\Service\DostavistaClients\DostavistaClient;
use Carbon\Carbon;

readonly class TransactionService
{

    public function __construct(
        private TransactionsRepository $transactionsRepository,
        private DateTimeMarkRepository $dateTimeMarkRepository,
        private DostavistaClient $dostavistaClient
    ){}

    public function fetch(): void
    {
        $to = Carbon::now();
        $from = $this->dateTimeMarkRepository->getLastImportTransactionsDateTimeMark()?->date_time;

        if (! $from) {
            $from = Carbon::now()->subHour();
        }

        $nextPageId = null;
        do {
            $data = $this->dostavistaClient->fetchTransactions($from, $to, $nextPageId);

            foreach ($data['transactions'] as $order) {
                $this->transactionsRepository->store($order);
            }

            $this->dateTimeMarkRepository->upsert(
                DateTimeMarkType::LAST_IMPORT_TRANSACTIONS,
                $to
            );

            $nextPageId = $data['next_page_id'];

        }while ($nextPageId);
    }
}
