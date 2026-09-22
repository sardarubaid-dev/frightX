<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Services\HblPdfService;

$testPayload = [
    "hbl_no" => "TEST-12345",
    "booking_no" => "BOOK-9999",
    "file_no" => "FILE-123",
    "shipper" => "SHIPPER TEST",
    "consignee" => "CONSIGNEE TEST",
    "notify_party" => "NOTIFY TEST",
    "agent_info" => "DELIVERY TEST",
    "forwarding_agent_ref" => "AGENT REF TEST",
    "country_of_origin" => "USA",
    "pre_carriage" => "TRUCK TEST",
    "place_of_receipt" => "RECEIPT TEST",
    "vessel_name" => "VESSEL TEST",
    "voyage_no" => "VOYAGE TEST",
    "port_of_loading" => "LOADING TEST",
    "port_of_discharge" => "DISCHARGE TEST",
    "place_of_delivery" => "DELIVERY TEST",
    "final_destination" => "DESTINATION TEST",
    "domestic_routing" => "ROUTING TEST",
    "containers_and_marks" => "MARKS TEST",
    "no_of_pkgs" => "PKGS TEST",
    "goods_description" => "DESCRIPTION TEST",
    "gross_weight" => "WEIGHT TEST",
    "measurement" => "MEASUREMENT TEST",
    "freight_terms" => "TERMS TEST",
    "freight_payable_at" => "PAYABLE TEST",
    "no_of_original_bl" => "BL TEST",
    "place_of_issue" => "ISSUE TEST",
    "date_of_issue" => "DATE TEST",
    "carrier_signature" => "SIGNATURE TEST"
];

$service = new HblPdfService("ntg_air", $testPayload);
$pdf = $service->generate();
file_put_contents("storage/app/hbl_ref/clone.pdf", $pdf);
exec("pdftoppm -png -r 150 storage/app/hbl_ref/clone.pdf storage/app/hbl_ref/clone_page");

// Create visual diff overlay
$orig = imagecreatefrompng("storage/app/hbl_ref/ntg_air_page-1.png");
$clone = imagecreatefrompng("storage/app/hbl_ref/clone_page-1.png");

$w = min(imagesx($orig), imagesx($clone));
$h = min(imagesy($orig), imagesy($clone));
$overlay = imagecreatetruecolor($w, $h);

for ($y = 0; $y < $h; $y++) {
    for ($x = 0; $x < $w; $x++) {
        $rgbO = imagecolorat($orig, $x, $y);
        $rO = ($rgbO >> 16) & 0xFF;
        
        $rgbC = imagecolorat($clone, $x, $y);
        $rC = ($rgbC >> 16) & 0xFF;
        
        // original is dark = Cyan, clone is dark = Red, both dark = Black, neither = White
        if ($rO < 128 && $rC < 128) {
            imagesetpixel($overlay, $x, $y, imagecolorallocate($overlay, 0, 0, 0));
        } elseif ($rO < 128) {
            imagesetpixel($overlay, $x, $y, imagecolorallocate($overlay, 0, 255, 255)); // Original = Cyan
        } elseif ($rC < 128) {
            imagesetpixel($overlay, $x, $y, imagecolorallocate($overlay, 255, 0, 0)); // Clone = Red
        } else {
            imagesetpixel($overlay, $x, $y, imagecolorallocate($overlay, 255, 255, 255));
        }
    }
}
imagepng($overlay, "storage/app/hbl_ref/overlay.png");
echo "Overlay generated at storage/app/hbl_ref/overlay.png\n";
