<?php

namespace App\Models;

use App\Traits\BelongsToTenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoTask extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'todo_tasks';

    protected $fillable = [
        'company_id',
        'module',
        'title',
        'description',
        'config',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'config' => 'array'
    ];
}
