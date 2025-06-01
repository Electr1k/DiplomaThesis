<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Репозиторий для пользователей
 */
class UserRepository
{
    /**
     * Получение всех пользователей
     * @return Collection<int, User>
     */
    public function getAll(array $params): Collection
    {
        return User::query()
            ->when(isset($params['search']), function (Builder $query) use ($params) {
                $query->where('surname', 'ILIKE', '%'.$params['search'].'%');
                $query->orWhere('name', 'ILIKE', '%'.$params['search'].'%');
                $query->orWhere('email', 'ILIKE', '%'.$params['search'].'%');
            })
            ->orderBy('id')
            ->get();
    }

    /**
     * Создание пользователя
     * @param array $data
     * @return User
     */
    public function store(array $data): User
    {
        return User::query()->create($data);
    }

    /**
     * Обновление пользователя
     * @param array $data
     * @param User $user
     * @return User
     */
    public function update(array $data, User $user): User
    {
        $user->update($data);

        return $user;
    }

    /**
     * Удаление пользователя
     * @param User $user
     * @return ?bool
     */
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }

}
