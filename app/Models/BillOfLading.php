<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfLading extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\BillOfLadingFactory> */
    use HasFactory;
}
