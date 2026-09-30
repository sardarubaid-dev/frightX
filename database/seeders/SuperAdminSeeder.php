<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@fms.com'],
            [
                'name' => 'Super Admin',
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'user_id' => 'SA001',
                'password' => Hash::make('SuperAdmin@123'),
                'role' => 'SuperAdmin',
                'status' => 'Enable',
                'company_id' => null,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Super Admin user created: superadmin@fms.com / SuperAdmin@123');
    }
}
