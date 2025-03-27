<?php

namespace App\Models;

use App\Models\Enums\Orders\PaymentMethod;
use App\Models\Enums\Orders\OrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель заказа
 * @property integer $order_id - Идентификатор заказа
 * @property integer $courier_id - Идентификатор курьера в Достависта
 * @property string $courier_first_name - Имя курьера
 * @property string $courier_last_name - Фамилия курьера
 * @property string $courier_middle_name - Отчество курьера
 * @property PaymentMethod $payment_method - Метод оплаты заказа
 * @property OrderStatus $order_status - Статус заказа
 * @property float $order_payment_amount - Сумма пополнения
 * @property float $service_commission_amount - Комиссия Достависты
 * @property float $partner_commission_amount - Комиссия партнера
 * @property float $courier_payment_amount - Курьерское вознаграждение
 * @property float $courier_additional_payments_amount - Компенсации минус штрафы
 * @property Carbon $order_accepted_datetime - Дата и время назначения курьера на заказ
 * @property Carbon $order_finished_datetime - Дата и время выполнения заказа курьером
 * @property string $order_first_point_address - Адрес первой точки
 * @property string $order_last_point_address - Адрес последней точки
 * @property Carbon $order_lead_time - Продолжительность выполнения заказа
 * @property Carbon $updated_datetime - Время изменения данных модели
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends Model
{
    protected $primaryKey = 'order_id';

    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'courier_id',
        'courier_first_name',
        'courier_last_name',
        'courier_middle_name',
        'payment_method',
        'order_status',
        'order_payment_amount',
        'service_commission_amount',
        'partner_commission_amount',
        'courier_payment_amount',
        'courier_additional_payments_amount',
        'order_accepted_datetime',
        'order_finished_datetime',
        'order_first_point_address',
        'order_last_point_address',
        'order_lead_time',
        'updated_datetime'
    ];

    protected $casts = [
        'order_payment_amount' => 'float',
        'service_commission_amount' => 'float',
        'partner_commission_amount' => 'float',
        'courier_payment_amount' => 'float',
        'courier_additional_payments_amount' => 'float',
        'payment_method' => PaymentMethod::class,
        'order_status' => OrderStatus::class,
    ];
}
