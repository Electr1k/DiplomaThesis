<?php

namespace App\Models;

use App\Models\Enums\Transactions\TransactionStatus;
use App\Models\Enums\Transactions\TransactionType;
use Carbon\Carbon;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Модель транзакции
 *
 * @property integer $transaction_id - Идентификатор транзакции в Достависта
 * @property integer $courier_id - Идентификатор курьера
 * @property integer $order_id - Идентификатор заказа
 * @property TransactionType $transaction_type - Тип транзакции
 * @property float $amount - Сумма транзакции
 * @property float $partner_commission_amount - Комиссия партнера
 * @property float $courier_payment_amount - Курьерское вознаграждение
 * @property Carbon $updated_datetime - Время изменения данных модели
 * @property integer $rollback_transaction_id - Идентификатор отмененной транзакции
 * @property TransactionStatus $transaction_status - Статус отката транзакции
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    public $incrementing = false;

    protected $fillable = [
        'transaction_id',
        'courier_id',
        'order_id',
        'transaction_type',
        'amount',
        'partner_commission_amount',
        'courier_payment_amount',
        'updated_datetime',
        'rollback_transaction_id',
        'transaction_status',
    ];

    protected $casts = [
        'transaction_type' => TransactionType::class,
        'amount' => 'float',
        'partner_commission_amount' => 'float',
        'courier_payment_amount' => 'float',
        'transaction_status' => TransactionStatus::class,
    ];
}
