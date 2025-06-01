<?php

namespace App\Repositories;

use App\Models\Transaction;

/**
 * Репозиторий для транзакций
 */
class TransactionsRepository
{

    /**
     * Создание транзакции в БД
     * @param array $data
     * @return Transaction
     */
    public function store(array $data): Transaction
    {
        return Transaction::query()->updateOrCreate(['transaction_id' => $data['transaction_id']], $data);
    }
}
