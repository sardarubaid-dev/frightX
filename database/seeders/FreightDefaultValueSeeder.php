<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FreightDefaultValue;

class FreightDefaultValueSeeder extends Seeder
{
    public function run(): void
    {
        // Sample data for Air Export (from screenshot)
        FreightDefaultValue::create([
            'office_type' => 'Office',
            'module' => 'air-export',
            'section' => 'invoice',
            'freight_code' => 'FCL FCL',
            'pc' => 'PREPAID',
            'type' => 'Our Sales',
            'unit' => 'UNIT',
            'currency' => 'USD',
            'volume' => 1,
            'rate' => 12.5,
            'amount' => 12.5,
            'agent_amount' => 19,
            'order' => 1
        ]);

        // You can add more sample data here if needed
        // For now, keeping it minimal so user can test the system
    }
}
