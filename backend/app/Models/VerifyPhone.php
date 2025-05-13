<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Попытка верификации номера
 *
 * @property integer $id - идентификатор попытки
 * @property string $phone - номер
 * @property string $ip - ip-адресс попытки
 * @property integer $code - код
 * @property integer $attempts - Количество неудачных попыток
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class VerifyPhone extends Model
{
    protected $fillable = [
        'phone',
        'ip',
        'code',
        'attempts',
    ];
}
