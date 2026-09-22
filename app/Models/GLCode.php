<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class GLCode extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'gl_codes';

    protected $fillable = [
        'company_id', 'gl_code', 'gl_name_eng', 'gl_name_local', 'name_type', 'sub',
        'aire_ap_code', 'detail', 'deposit', 'forgotten', 'transaction', 'is_active'
    ];

    protected $casts = [
        'aire_ap_code' => 'boolean',
        'detail' => 'boolean',
        'deposit' => 'boolean',
        'forgotten' => 'boolean',
        'transaction' => 'boolean',
        'is_active' => 'boolean',
    ];
}
