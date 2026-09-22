<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentMemoConfig extends Model
{
    protected $fillable = [
        'module',
        'section',
        'field_name',
        'is_enabled',
        'order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'order' => 'integer',
    ];
}

