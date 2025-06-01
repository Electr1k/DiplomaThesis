<?php

namespace App\Console\Commands;

use App\Service\OrderService;
use App\Service\TransactionService;
use Illuminate\Console\Command;

/**
 * Команда для импорта транзакций
 */
class FetchTransactionsCommand extends Command
{
    protected $signature = 'app:fetch-transactions-command';

    protected $description = 'Fetch transactions from Dostavista API';

    public function handle(TransactionService $transactionService): void
    {
        $transactionService->fetch();
    }
}
