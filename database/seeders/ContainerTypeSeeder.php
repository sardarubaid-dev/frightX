<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContainerType;

class ContainerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $containerTypes = [
            ['code' => '12RF', 'name' => '12RF', 'description' => '12RF-12FT REEFER CONTAINER', 'ams_type_code' => 'RF', 'type' => 'RF', 'teu' => 0.60, 'is_active' => true],
            ['code' => '20DC', 'name' => '20DC', 'description' => '20DC-20FT DRY CONTAINER', 'ams_type_code' => 'DC', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20FR', 'name' => '20FR', 'description' => '20FR-20FT FLAT RACK', 'ams_type_code' => 'FR', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20GP', 'name' => '20GP', 'description' => '20GP-20FT GENERAL PURPOSE', 'ams_type_code' => 'GP', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20HC', 'name' => '20HC', 'description' => '20HC-20FT HIGH CUBE', 'ams_type_code' => 'HC', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20HQ', 'name' => '20HQ', 'description' => '20HQ-20FT HIGH CUBE', 'ams_type_code' => 'HQ', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20NOR', 'name' => '20NOR', 'description' => '20NOR-20FT NORMAL CONTAINER', 'ams_type_code' => 'NOR', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20OT', 'name' => '20OT', 'description' => '20OT-20FT OPEN TOP', 'ams_type_code' => 'OT', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20PF', 'name' => '20PF', 'description' => '20PF-20FT PLATFORM', 'ams_type_code' => 'PF', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20RF', 'name' => '20RF', 'description' => '20RF-20FT REEFER CONTAINER', 'ams_type_code' => 'RF', 'type' => 'RF', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20RH', 'name' => '20RH', 'description' => '20RH-20FT REEFER HIGH CUBE', 'ams_type_code' => 'RH', 'type' => 'RF', 'teu' => 1.00, 'is_active' => true],
            ['code' => '20TK', 'name' => '20TK', 'description' => '20TK-20FT TANK CONTAINER', 'ams_type_code' => 'TK', 'type' => '20\'', 'teu' => 1.00, 'is_active' => true],
            ['code' => '40DC', 'name' => '40DC', 'description' => '40DC-40FT DRY CONTAINER', 'ams_type_code' => 'DC', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40FR', 'name' => '40FR', 'description' => '40FR-40FT FLAT RACK', 'ams_type_code' => 'FR', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40GP', 'name' => '40GP', 'description' => '40GP-40FT GENERAL PURPOSE', 'ams_type_code' => 'GP', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40HC', 'name' => '40HC', 'description' => '40HC-40FT HIGH CUBE', 'ams_type_code' => 'HC', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40HQ', 'name' => '40HQ', 'description' => '40HQ-40FT HIGH CUBE', 'ams_type_code' => 'HQ', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40NOR', 'name' => '40NOR', 'description' => '40NOR-40FT NORMAL CONTAINER', 'ams_type_code' => 'NOR', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40OT', 'name' => '40OT', 'description' => '40OT-40FT OPEN TOP', 'ams_type_code' => 'OT', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40PF', 'name' => '40PF', 'description' => '40PF-40FT PLATFORM', 'ams_type_code' => 'PF', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40RF', 'name' => '40RF', 'description' => '40RF-40FT REEFER CONTAINER', 'ams_type_code' => 'RF', 'type' => 'RF', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40RH', 'name' => '40RH', 'description' => '40RH-40FT REEFER HIGH CUBE', 'ams_type_code' => 'RH', 'type' => 'RF', 'teu' => 2.00, 'is_active' => true],
            ['code' => '40TK', 'name' => '40TK', 'description' => '40TK-40FT TANK CONTAINER', 'ams_type_code' => 'TK', 'type' => '40\'', 'teu' => 2.00, 'is_active' => true],
            ['code' => '45HC', 'name' => '45HC', 'description' => '45HC-45FT HIGH CUBE', 'ams_type_code' => 'HC', 'type' => '45\'', 'teu' => 2.25, 'is_active' => true],
            ['code' => '45HQ', 'name' => '45HQ', 'description' => '45HQ-45FT HIGH CUBE', 'ams_type_code' => 'HQ', 'type' => '45\'', 'teu' => 2.25, 'is_active' => true],
        ];

        foreach ($containerTypes as $type) {
            ContainerType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
