<?php

namespace App\Repositories;

use App\Models\Cabinet;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class CabinetRepository
{
    /**
     * @return Collection<int, Cabinet>
     */
    public function getAll(array $param): Collection
    {
        return Cabinet::query()
            ->when(isset($param['search']), function (Builder $query) use ($param) {
                $query->where('region_name', 'ILIKE', '%'.$param['search'].'%');
            })
            ->when(isset($param['legal_name']), function (Builder $query) use ($param) {
                $query->orWhere('legal_name', 'ILIKE', '%'.$param['search'].'%');
            })
            ->get();
    }

    /**
     * @param array $data
     * @return Cabinet
     */
    public function store(array $data): Cabinet
    {
        return Cabinet::query()->updateOrCreate(['courier_partner_id' => $data['courier_partner_id']], $data);
    }
}
