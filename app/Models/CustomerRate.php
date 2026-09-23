<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class CustomerRate extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function tradePartner()
    {
        return $this->belongsTo(TradePartner::class);
    }
}
