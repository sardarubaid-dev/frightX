<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ics2Filing extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\Ics2FilingFactory> */
    use HasFactory;
}
