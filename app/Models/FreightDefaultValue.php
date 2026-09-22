<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightDefaultValue extends Model
{
    protected $fillable = [
        'office_type',
        'module',
        'section',
        'ship_mode',
        'freight_code',
        'pc',
        'type',
        'unit',
        'currency',
        'volume',
        'rate',
        'amount',
        'agent_amount',
        'order'
    ];

    protected $casts = [
        'volume' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
        'agent_amount' => 'decimal:2',
        'order' => 'integer'
    ];
}
