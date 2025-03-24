<?php

namespace App\Models;

use App\Models\Enums\ImportCourierStatusEnum;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id - Идентификатор курьера (внутренний)
 * @property integer $courier_id - Идентификатор курьера в Достависта
 * @property string $name - Имя курьера
 * @property string $surname - Фамилия курьера
 * @property string $middlename - Отчество курьера
 * @property string $phone - Телефонный номер курьера
 * @property string $email- Email курьера
 * @property Date $date_of_birth - Дата рождения
 * @property integer $courier_partner_id - Идентификатор кабинета, которому пренадлежит курьер
 * @property ImportCourierStatusEnum $status - Внутренний статус регистрации курьера
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Cabinet|null $cabinet - Кабинет, к которому относится курьер
 */
class Courier extends Model
{
    protected $fillable = [
        'courier_id',
        'name',
        'surname',
        'middle_name',
        'phone',
        'email',
        'date_of_birth',
        'citizenship',
        'courier_partner_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => ImportCourierStatusEnum::class,
    ];


    /**
     * @return BelongsTo<Cabinet, $this>
     */
    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class, 'courier_partner_id', 'courier_partner_id');
    }
}
