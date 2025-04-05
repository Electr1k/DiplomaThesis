<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель кабинета партнера
 * @property integer $courier_partner_id - Идентификатор кабинета партнера
 * @property string $region_name - Регион партнёра
 * @property string $vehicle_type_name - Тип транспорта партнёра
 * @property string $legal_name - Наименование юридического лица
 * @property float $partner_commission_part - Процент комиссии партнёра
 * @property boolean $is_for_taking_available_couriers - Особый кабинет для особых курьеров
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Cabinet extends Model
{
    protected $primaryKey = 'courier_partner_id';

    public $incrementing = false;

    protected $fillable = [
        'courier_partner_id',
        'region_name',
        'vehicle_type_name',
        'legal_name',
        'partner_commission_part',
        'is_for_taking_available_couriers',
    ];

    protected $casts = [
        'partner_commission_part' => 'float',
        'is_for_taking_available_couriers' => 'boolean',
    ];

}
