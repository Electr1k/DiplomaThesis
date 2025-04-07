<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель пользователя
 * @property string $id - Идентификатор пользователя
 * @property string $name - Имя
 * @property string $surname - Фамилия
 * @property string $middle_name - Отчество
 * @property string $email - Email
 * @property string $role_id - Идентификатор роли
 * @property Role $role - Роль пользователя
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'surname',
        'middle_name',
        'email',
        'password',
        'role_id',
    ];


    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
