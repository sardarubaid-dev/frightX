<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class BillingCode extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'company_id', 'code', 'name_eng', 'name_local', 'revenue', 'cost', 'credit', 'debit',
        'department', 'ar', 'ap', 'dc', 'ba', 'payroll', 'ohw', 'oim', 'aim',
        'aie', 'oem', 'oew', 'aerial', 'alog', 'tk', 'misc', 'wh', 'is_active'
    ];

    protected $casts = [
        'ar' => 'boolean',
        'ap' => 'boolean',
        'dc' => 'boolean',
        'ba' => 'boolean',
        'payroll' => 'boolean',
        'ohw' => 'boolean',
        'oim' => 'boolean',
        'aim' => 'boolean',
        'aie' => 'boolean',
        'oem' => 'boolean',
        'oew' => 'boolean',
        'aerial' => 'boolean',
        'alog' => 'boolean',
        'tk' => 'boolean',
        'misc' => 'boolean',
        'wh' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function iataItems()
    {
        return $this->hasMany(IATAChargeItem::class, 'freight_code_id');
    }
}
