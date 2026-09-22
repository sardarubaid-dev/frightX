<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use App\Models\Company;

trait BelongsToTenant
{
    /**
     * Boot the trait to attach global tenant scoping and auto-assignment.
     */
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (empty($model->company_id) && auth()->check() && auth()->user()->company_id) {
                $model->company_id = auth()->user()->company_id;
            }
        });
    }

    /**
     * Relationship to Company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
