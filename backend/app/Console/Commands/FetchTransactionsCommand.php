<?php

namespace App\Console\Commands;

use App\Service\OrderService;
use App\Service\TransactionService;
use Illuminate\Console\Command;

class FetchTransactionsCommand extends Command
{
    protected $signature = 'app:fetch-transactions-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch transactions from Dostavista API';

    public function handle(TransactionService $transactionService): void
    {
        $transactionService->fetch();
    }
}
