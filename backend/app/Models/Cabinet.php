<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    protected $primaryKey = 'courier_partner_id';

    public $incrementing = false;

    protected $fillable = [
        'courier_partner_id',
        'region_name',
        'vehicle_type_name',
        'legal_name',
        'partner_commission_part',
        'is_for_taking_available_couriers',
    ];

    protected $casts = [
        'partner_commission_part' => 'float',
        'is_for_taking_available_couriers' => 'boolean',
    ];

}
