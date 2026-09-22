<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'ams_type_code',
        'type',
        'teu',
        'is_active',
    ];

    protected $casts = [
        'teu' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
