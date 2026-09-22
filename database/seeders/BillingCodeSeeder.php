<?php

namespace Database\Seeders;

use App\Models\BillingCode;
use App\Models\IATAChargeItem;
use Illuminate\Database\Seeder;

class BillingCodeSeeder extends Seeder
{
    public function run()
    {
        // Sample Billing Codes
        $codes = [
            ['code' => 'ACDSPC', 'name_eng' => 'FUEL SURCHARGE', 'name_local' => 'FUEL SURCHARGE', 'revenue' => '40100', 'cost' => '40100', 'credit' => '41043', 'debit' => '41043', 'department' => 'All', 'oim' => true, 'aim' => true, 'oem' => true, 'is_active' => true],
            ['code' => 'ACDTRM', 'name_eng' => 'SECURITY CHARGE', 'name_local' => 'SECURITY CHARGE', 'revenue' => '40100', 'cost' => '40100', 'credit' => '41043', 'debit' => '41043', 'department' => 'All', 'oim' => true, 'aim' => true, 'is_active' => true],
            ['code' => 'ADEHTC', 'name_eng' => 'HANDLING CHARGE', 'name_local' => 'HANDLING CHARGE', 'revenue' => '40152', 'cost' => '40152', 'credit' => '41043', 'debit' => '41043', 'department' => 'All', 'oim' => true, 'aim' => true, 'is_active' => true],
            ['code' => 'AEDGCS', 'name_eng' => 'DANGEROUS GOODS HANDLING', 'name_local' => 'DANGEROUS GOODS HANDLING', 'revenue' => '40152', 'cost' => '40152', 'credit' => '41043', 'debit' => '41043', 'oim' => true, 'aim' => true, 'is_active' => true],
            ['code' => 'AEDSTRK', 'name_eng' => 'TRUCKING CHARGE', 'name_local' => 'TRUCKING CHARGE', 'revenue' => '40110', 'cost' => '40110', 'credit' => '41043', 'debit' => '41043', 'tk' => true, 'is_active' => true],
            ['code' => 'AEDWARTE', 'name_eng' => 'WAREHOUSE TRANSFER FEE', 'name_local' => 'WAREHOUSE TRANSFER FEE', 'revenue' => '40110', 'cost' => '40110', 'credit' => '41043', 'debit' => '41043', 'wh' => true, 'is_active' => true],
            ['code' => 'AEPBLC', 'name_eng' => 'LETTER OF CREDIT BANKING', 'name_local' => 'LETTER OF CREDIT BANKING', 'revenue' => '40195', 'cost' => '40195', 'credit' => '41043', 'debit' => '41043', 'is_active' => true],
            ['code' => 'AORBLCD', 'name_eng' => 'CERTIFICATE OF ORIGIN', 'name_local' => 'CERTIFICATE OF ORIGIN', 'revenue' => '40190', 'cost' => '40190', 'credit' => '41043', 'debit' => '41043', 'is_active' => true],
            ['code' => 'ACTINS', 'name_eng' => 'INSURANCE PREMIUM', 'name_local' => 'INSURANCE PREMIUM', 'revenue' => '40183', 'cost' => '40183', 'credit' => '41043', 'debit' => '41043', 'is_active' => true],
            ['code' => 'ABTADCAN', 'name_eng' => 'PACKING', 'name_local' => 'PACKING', 'revenue' => '40140', 'cost' => '40140', 'credit' => '41043', 'debit' => '41043', 'is_active' => true],
        ];

        foreach ($codes as $code) {
            BillingCode::create($code);
        }

        // Sample IATA Charge Items for Data Mapping
        $iataItems = [
            ['code' => 'AA', 'name' => 'Airport/Carrier', 'freight_code_id' => null],
            ['code' => 'AC', 'name' => 'Airway Bill Container', 'freight_code_id' => null],
            ['code' => 'AD', 'name' => 'Advance on Freight/Tax', 'freight_code_id' => null],
            ['code' => 'AY', 'name' => 'Airways', 'freight_code_id' => null],
            ['code' => 'BA', 'name' => 'Advance charge/duties/guarantees', 'freight_code_id' => null],
            ['code' => 'BB', 'name' => 'Airport Levy', 'freight_code_id' => null],
            ['code' => 'BC', 'name' => 'CASS Copy', 'freight_code_id' => null],
            ['code' => 'BF', 'name' => 'Bulk/Air Discount', 'freight_code_id' => null],
            ['code' => 'BG', 'name' => 'Bridging', 'freight_code_id' => null],
            ['code' => 'CA', 'name' => 'Congestion/documentation of all documents', 'freight_code_id' => null],
            ['code' => 'CB', 'name' => 'Annual dues or fee for customs brokers', 'freight_code_id' => null],
            ['code' => 'CC', 'name' => 'Embassy and similar use-Certification', 'freight_code_id' => null],
            ['code' => 'CD', 'name' => 'Customs paper/documents', 'freight_code_id' => null],
            ['code' => 'CE', 'name' => 'Clearance and Other Customs expense Charges', 'freight_code_id' => null],
            ['code' => 'CJ', 'name' => 'Business Limited advertised to beneficiaries', 'freight_code_id' => null],
            ['code' => 'CL', 'name' => 'Container Load/Load Deposit', 'freight_code_id' => null],
            ['code' => 'CS', 'name' => 'Insurance and handling - Origin', 'freight_code_id' => null],
            ['code' => 'CT', 'name' => 'Clearance and Other (customs expense charges)', 'freight_code_id' => null],
            ['code' => 'DA', 'name' => 'Dangerous cargo', 'freight_code_id' => null],
            ['code' => 'HA', 'name' => 'Inland Tax', 'freight_code_id' => null],
            ['code' => 'HB', 'name' => 'Disbursement', 'freight_code_id' => null],
            ['code' => 'HC', 'name' => 'Is Advance (Emergency/export or it)', 'freight_code_id' => null],
            ['code' => 'HD', 'name' => 'Providing ULD (Load Elected)', 'freight_code_id' => null],
            ['code' => 'HE', 'name' => 'Courier', 'freight_code_id' => null],
            ['code' => 'HF', 'name' => 'Providing ULD (Load Charged)', 'freight_code_id' => null],
            ['code' => 'HG', 'name' => 'Rental cargo', 'freight_code_id' => null],
            ['code' => 'JA', 'name' => 'Miscellaneous charges', 'freight_code_id' => null],
            ['code' => 'MA', 'name' => 'Banking draft/direct usage', 'freight_code_id' => null],
            ['code' => 'MB', 'name' => 'Handling unit cargo', 'freight_code_id' => null],
            ['code' => 'MC', 'name' => 'Storage/service/all expenses (In-bound)', 'freight_code_id' => null],
            ['code' => 'QE', 'name' => 'Miscellaneous surcharge', 'freight_code_id' => null],
            ['code' => 'SA', 'name' => 'Fuel Surcharge/Tax (At the Import point)', 'freight_code_id' => null],
            ['code' => 'SB', 'name' => 'Storage Tax', 'freight_code_id' => null],
            ['code' => 'SC', 'name' => 'Value Added Tax (Be Begins point)', 'freight_code_id' => null],
            ['code' => 'SD', 'name' => 'Statistical Tax', 'freight_code_id' => null],
            ['code' => 'SE', 'name' => 'Payroll', 'freight_code_id' => null],
            ['code' => 'SF', 'name' => 'A value is sales tax (General or the Export)', 'freight_code_id' => null],
            ['code' => 'SG', 'name' => 'Screen Tax', 'freight_code_id' => null],
            ['code' => 'TA', 'name' => 'Onward (Airport Transfer)', 'freight_code_id' => null],
            ['code' => 'TB', 'name' => 'Special Plans', 'freight_code_id' => null],
            ['code' => 'TC', 'name' => 'Documentary special Commodity', 'freight_code_id' => null],
            ['code' => 'TE', 'name' => 'Weather Time', 'freight_code_id' => null],
            ['code' => 'TF', 'name' => 'Weight', 'freight_code_id' => null],
            ['code' => 'TG', 'name' => 'Telex/wiring/transfer (Changes)', 'freight_code_id' => null],
        ];

        foreach ($iataItems as $item) {
            IATAChargeItem::create($item);
        }
    }
}
