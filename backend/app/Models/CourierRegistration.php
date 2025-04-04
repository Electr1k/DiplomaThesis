<?php

namespace App\Models;

use App\Models\Enums\CourierRegistrationStatusEnum;
use App\Models\Enums\Couriers\Citizenship;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель регистрации курьера
 * @property integer $id - Идентификатор курьера (внутренний)
 * @property integer $courier_id - Идентификатор курьера в Достависта
 * @property string $name - Имя курьера
 * @property string $surname - Фамилия курьера
 * @property string $middle_name - Отчество курьера
 * @property string $phone - Телефонный номер курьера
 * @property string $email- Email курьера
 * @property Date $date_of_birth - Дата рождения
 * @property Citizenship $citizenship - Гражданство
 * @property integer $courier_partner_id - Идентификатор кабинета, которому пренадлежит курьер
 * @property CourierRegistrationStatusEnum $status - Внутренний статус регистрации курьера
 * @property string $passport_number - Серия и номер паспорта
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Cabinet|null $cabinet - Кабинет, к которому относится курьер
 */
class CourierRegistration extends Model
{

    protected $primaryKey = 'id';
    protected $fillable = [
        'courier_id',
        'name',
        'surname',
        'middle_name',
        'phone',
        'email',
        'date_of_birth',
        'citizenship',
        'passport_number',
        'courier_partner_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => CourierRegistrationStatusEnum::class,
    ];


    /**
     * @return BelongsTo<Cabinet, $this>
     */
    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class, 'courier_partner_id', 'courier_partner_id');
    }
}
