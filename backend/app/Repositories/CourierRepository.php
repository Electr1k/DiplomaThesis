<?php

namespace App\Repositories;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CourierRepository
{
    /**
     * @return Collection<int, Courier>
     */
    public function getAll(array $params): Collection
    {
        return Courier::query()
            ->when(isset($params['search']), function (Builder $query) use ($params) {
                $query->where('phone', 'ILIKE', '%'.$params['search'].'%')
                    ->orWhere('surname', 'ILIKE', '%'.$params['search'].'%');
            })
            ->get();
    }

    /**
     * @return Collection<int, Courier>
     */
    public function getInactive(array $params): Collection
    {
        return Courier::query()
            ->where('last_order_datetime', '<=', now()->subDays(14))
            ->when(isset($params['search']), function (Builder $query) use ($params) {
                $query->where(function(Builder $query) use ($params) {
                    $query->where('phone', 'ILIKE', '%'.$params['search'].'%')
                        ->orWhere('surname', 'ILIKE', '%'.$params['search'].'%');
                });
            })
            ->orderByDesc('last_order_datetime')
            ->get();
    }

    /**
     * @param array $data
     * @return Courier
     */
    public function store(array $data): Courier
    {
        return Courier::query()->updateOrCreate(['phone' => $data['phone']], $data);
    }
}
