<?php

namespace Database\Seeders;

use App\Models\GLCode;
use Illuminate\Database\Seeder;

class GLCodeSeeder extends Seeder
{
    public function run()
    {
        $codes = [
            ['gl_code' => '10001', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => '현금', 'is_active' => true, 'aire_ap_code' => true, 'detail' => true, 'deposit' => true],
            ['gl_code' => '10002', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => '예금', 'is_active' => true, 'aire_ap_code' => true, 'detail' => true, 'deposit' => true],
            ['gl_code' => '10041', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'BANK ACCOUNT', 'is_active' => true, 'detail' => true],
            ['gl_code' => '10162', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'ACCOUNT RECEIVABLES', 'is_active' => true, 'aire_ap_code' => true, 'transaction' => true],
            ['gl_code' => '11001', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'CASH IN BANK - DEPOSIT CIBM', 'is_active' => true, 'detail' => true],
            ['gl_code' => '14220', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'CASH IN BANK - DEPOSIT CIBM', 'is_active' => true, 'forgotten' => true],
            ['gl_code' => '14231', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'DND BANK 0911', 'is_active' => true, 'aire_ap_code' => true, 'transaction' => true],
            ['gl_code' => '14232', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'CASH IN BANK - CHECKING 9812', 'is_active' => true, 'detail' => true],
            ['gl_code' => '14244', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'CASH IN BANK - ANALYSIS 5844', 'is_active' => true, 'transaction' => true],
            ['gl_code' => '14245', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'CHASE BANK - CHECKING 0582', 'is_active' => true, 'detail' => true],
            ['gl_code' => '14246', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'BOA - CHECKING 3976', 'is_active' => true, 'aire_ap_code' => true],
            ['gl_code' => '14247', 'gl_name_eng' => 'CURRENT ASSET', 'gl_name_local' => 'CURRENT ASSET', 'name_type' => 'ASSET', 'sub' => 'HASE BANK - CHECKING 0582', 'is_active' => true],
        ];

        foreach ($codes as $code) {
            GLCode::create($code);
        }
    }
}
