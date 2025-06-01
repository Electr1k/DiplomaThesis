<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель разрешения
 *
 * @property string $code - Код
 * @property string $name - Название
 */
class Permission extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name'
    ];

}
