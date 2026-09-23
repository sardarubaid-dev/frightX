<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoTracking extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\CargoTrackingFactory> */
    use HasFactory;
}
