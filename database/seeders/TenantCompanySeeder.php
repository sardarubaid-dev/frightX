<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TenantCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Default Company 1
        Company::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Main Freight Tenant',
                'code' => 'MAIN',
                'subdomain' => 'mainfreight',
                'status' => 'active',
            ]
        );

        // 2. New Tenant Company 2
        $company2 = Company::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'Apex Global Logistics',
                'code' => 'APEX',
                'subdomain' => 'apex',
                'status' => 'active',
            ]
        );

        // 3. User for Company 2
        User::updateOrCreate(
            ['email' => 'admin@apexlogistics.com'],
            [
                'company_id' => $company2->id,
                'user_id' => 'APEX001',
                'first_name' => 'Apex',
                'last_name' => 'Admin',
                'name' => 'Apex Admin',
                'password' => Hash::make('password123'),
                'status' => 'Enable',
            ]
        );
    }
}
