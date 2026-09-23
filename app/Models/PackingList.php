<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use BelongsToTenant;

    /** @use HasFactory<\Database\Factories\PackingListFactory> */
    use HasFactory;
}
