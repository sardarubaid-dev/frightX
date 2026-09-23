<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use BelongsToTenant;

    protected $table = 'activity_logs';

    protected $fillable = [
        'company_id',
        'user_id', 'action', 'description', 'model_type', 'model_id',
        'ip_address', 'user_agent', 'old_values', 'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
