<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $users = [
            [
                'user_id' => 'user52',
                'first_name' => 'Jessica',
                'last_name' => 'Sullivan',
                'name' => 'Jessica Sullivan',
                'email' => 'user52@hardicoretech.co',
                'password' => Hash::make('password123'),
                'office_code' => 'MEO',
                'office_name' => 'FREIGHTX',
                'department_code' => '',
                'department_name' => '',
                'branch' => '',
                'role' => 'Operation',
                'status' => 'Enable',
                'create_date' => now()->subDays(1000),
            ],
            [
                'user_id' => 'user19',
                'first_name' => 'Isabel',
                'last_name' => 'Sloan',
                'name' => 'Isabel Sloan',
                'email' => 'user19@hardicoretech.co',
                'password' => Hash::make('password123'),
                'office_code' => 'MEO',
                'office_name' => 'FREIGHTX',
                'department_code' => '',
                'department_name' => '',
                'branch' => '',
                'role' => 'Admin',
                'status' => 'Disable',
                'create_date' => now()->subDays(950),
            ],
            [
                'user_id' => 'user88',
                'first_name' => 'Jennifer',
                'last_name' => 'Sanders',
                'name' => 'Jennifer Sanders',
                'email' => 'user88@hardicoretech.co',
                'password' => Hash::make('password123'),
                'office_code' => 'MEO',
                'office_name' => 'FREIGHTX',
                'department_code' => '',
                'department_name' => '',
                'branch' => '',
                'role' => 'Admin',
                'status' => 'Enable',
                'create_date' => now()->subDays(2800),
            ],
            [
                'user_id' => 'user77',
                'first_name' => 'Jasmine',
                'last_name' => 'Morris',
                'name' => 'Jasmine Morris',
                'email' => 'user77@hardicoretech.co',
                'password' => Hash::make('password123'),
                'office_code' => 'MEO',
                'office_name' => 'FREIGHTX',
                'department_code' => '',
                'department_name' => '',
                'branch' => '',
                'role' => 'Operation',
                'status' => 'Enable',
                'create_date' => now()->subDays(2500),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('User management sample data seeded successfully!');
    }
}

