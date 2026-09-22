<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwbNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_date',
        'carrier_id',
        'prefix',
        'begin_no',
        'end_no',
        'total_count',
        'available_count',
        'reserved_count',
        'assigned_count',
        'latest_assigned_no',
        'remark',
    ];

    public function carrier()
    {
        return $this->belongsTo(TradePartner::class, 'carrier_id');
    }
}
