<?php

namespace App\Repositories;

use App\Models\CourierRegistration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CourierRegistrationRepository
{
    /**
     * @return Collection<int, CourierRegistration>
     */
    public function getAll(array $params): Collection
    {
        return CourierRegistration::query()
            ->when(isset($params['search']), function (Builder $query) use ($params) {
                $query->where('phone', 'ILIKE', '%'.$params['search'].'%')
                    ->orWhere('surname', 'ILIKE', '%'.$params['search'].'%');
            })
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * @param array $data
     * @return CourierRegistration
     */
    public function store(array $data): CourierRegistration
    {
        return CourierRegistration::query()->updateOrCreate(['phone' => $data['phone']], $data);
    }

    public function update()
    {

    }
}
