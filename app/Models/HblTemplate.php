<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HblTemplate extends Model
{
    use HasFactory;

    protected $table = 'hbl_templates';

    protected $fillable = [
        'name', 'title', 'content', 'css', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hbls()
    {
        return $this->hasMany(OceanExportHbl::class, 'hbl_template_id');
    }
}
