<?php

namespace App\Models;

use App\Models\Enums\DateTimeMarkType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Временная метка
 *
 * @property DateTimeMarkType $type - Тип метки
 * @property Carbon $date_time - Дата и время
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class DateTimeMark extends Model
{
    protected $primaryKey = 'date_time_marks';

    public $incrementing = false;

    protected $fillable = [
        'type',
        'date_time',
    ];

}
