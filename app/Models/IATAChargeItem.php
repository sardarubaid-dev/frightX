<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IATAChargeItem extends Model
{
    use HasFactory;

    protected $table = 'iata_charge_items';

    protected $fillable = [
        'code',
        'name',
        'freight_code_id'
    ];

    protected $casts = [
        'freight_code_id' => 'integer',
    ];

    public function freightCode()
    {
        return $this->belongsTo(BillingCode::class, 'freight_code_id');
    }
}
