<?php

namespace App\Models\Enums\Transactions;

enum TransactionStatus: string
{
    // Активная транзакция, меняющая баланс курьера или клиента
    case ACTIVE = 'active';

    // Транзакция отменяет другую транзакцию
    case ROLLBACK = 'rollback';

    // Транзакция отменена другой транзакцией
    case ROLLED_OUT = 'rolled_out';
}
