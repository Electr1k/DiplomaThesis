<?php

namespace App\Models\Enums\Transactions;

enum TransactionType: string
{
    // Получение курьером мотивационного бонуса
    case BONUS = 'bonus';

    // Получение курьером компенсации
    case COMPENSATION = 'compensation';

    // Получение курьером штрафа
    case FINE = 'fine';

    // Транзакция в рамках заказа
    case ORDER = 'order';
}
