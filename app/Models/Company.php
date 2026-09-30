<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'subdomain',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function modules()
    {
        return $this->hasMany(CompanyModule::class);
    }

    public function hasModule(string $key): bool
    {
        return $this->modules()->where('module_key', $key)->exists();
    }

    public function moduleKeys(): array
    {
        return $this->modules()->pluck('module_key')->toArray();
    }
}
