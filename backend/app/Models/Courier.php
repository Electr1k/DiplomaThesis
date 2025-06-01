<?php

namespace App\Models;

use App\Models\Enums\Couriers\CourierStatus;
use App\Models\Enums\Transactions\TransactionType;
use App\Repositories\TransactionsRepository;
use Carbon\Carbon;
use Database\Factories\CourierFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель курьера
 *
 * @property integer $courier_id - Идентификатор курьера в Достависта
 * @property string $name - Имя курьера
 * @property string $surname - Фамилия курьера
 * @property string $middle_name - Отчество курьера
 * @property CourierStatus $status - Статус курьера
 * @property Carbon $ban_end_datetime- Email курьера
 * @property string $phone - Телефон
 * @property Carbon $registered_datetime - Дата и время регистрации курьера
 * @property Carbon $updated_datetime - Дата и время последнего изменения данных курьера
 * @property integer $orders_completed_count - Количество выполненных заказов курьером у данного партнёра
 * @property Carbon $first_order_datetime - Дата и время выполнения первого заказа курьером у данного партнёра
 * @property Carbon $last_order_datetime - Дата и время выполнения последнего заказа курьером у данного партнёра
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Courier extends Model
{
    /** @use HasFactory<CourierFactory> */
    use HasFactory;

    protected $primaryKey = 'courier_id';

    protected $fillable = [
        'courier_id',
        'name',
        'surname',
        'middle_name',
        'status',
        'ban_end_datetime',
        'phone',
        'registered_datetime',
        'updated_datetime',
        'orders_completed_count',
        'first_order_datetime',
        'last_order_datetime'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => CourierStatus::class,
    ];

    /**
     * @return HasMany<Transaction,$this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'courier_id', 'courier_id');
    }


    public function getSumOrders(): float
    {
        return $this->transactions()
            ->where('courier_id', $this->courier_id)
            ->where('transaction_type', TransactionType::ORDER)
            ->sum('amount');
    }


    public function getSumBonus(): float
    {
        return $this->transactions()
            ->where('courier_id', $this->courier_id)
            ->where('transaction_type', TransactionType::BONUS)
            ->sum('amount');
    }

    public function getSumFine(): float
    {
        return $this->transactions()
            ->where('courier_id', $this->courier_id)
            ->where('transaction_type', TransactionType::FINE)
            ->sum('amount');
    }
}
