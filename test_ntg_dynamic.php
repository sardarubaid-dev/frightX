<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Services\HblPdfService;

$testPayload = [
    "hbl_no" => "NTG-HBL-777",
    "booking_no" => "BK-5555",
    "file_no" => "FL-888",
    "shipper" => "APPLE INC.\nONE APPLE PARK WAY\nCUPERTINO, CA 95014",
    "consignee" => "SAMSUNG ELECTRONICS\n129 SAMSUNG-RO, YEONGTONG-GU\nSUWON-SI, GYEONGGI-DO, KOREA",
    "notify_party" => "SAME AS CONSIGNEE",
    "agent_info" => "NTG AIR & OCEAN KOREA\n123 LOGISTICS BLVD\nSEOUL, KOREA",
    "forwarding_agent_ref" => "FWD-123",
    "country_of_origin" => "UNITED STATES",
    "pre_carriage" => "TRUCK CO.",
    "place_of_receipt" => "LOS ANGELES, CA",
    "vessel_name" => "MSC OLIVER",
    "voyage_no" => "029W",
    "port_of_loading" => "LOS ANGELES",
    "port_of_discharge" => "BUSAN",
    "place_of_delivery" => "BUSAN CY",
    "final_destination" => "SEOUL",
    "domestic_routing" => "HOLD AT DESTINATION",
    "containers_and_marks" => "MSCU1234567\nSEAL: 987654\n40HC",
    "no_of_pkgs" => "100 PALLETS",
    "goods_description" => "ELECTRONIC COMPONENTS\nHS CODE: 8542.31\nFREIGHT PREPAID",
    "gross_weight" => "15,000.00 KGS",
    "measurement" => "45.50 CBM",
    "freight_terms" => "FREIGHT PREPAID",
    "freight_payable_at" => "LOS ANGELES, CA",
    "no_of_original_bl" => "3 (THREE)",
    "place_of_issue" => "LOS ANGELES, CA",
    "date_of_issue" => "08/24/2026",
    "carrier_signature" => "NTG AGENT SIGNATURE"
];

$service = new HblPdfService("ntg_air", $testPayload);
$pdf = $service->generate();
file_put_contents("storage/app/hbl_ref/ntg_air_dynamic_test.pdf", $pdf);
echo "Dynamic PDF generated at storage/app/hbl_ref/ntg_air_dynamic_test.pdf\n";
