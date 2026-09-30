<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModule extends Model
{
    protected $fillable = ['company_id', 'module_key'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
