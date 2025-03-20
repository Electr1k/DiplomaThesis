<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
