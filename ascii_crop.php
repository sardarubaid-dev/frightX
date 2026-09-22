<?php
$img = imagecreatefrompng("storage/app/hbl_ref/ntg_air_page-1.png");
$w = imagesx($img);
$h = imagesy($img);

// Crop bottom section: Y=1500 to 1754, X=0 to 1241
// To make it fit terminal, we scale down by 2 or just print
$scale = 3;
for ($y = 1500; $y < $h; $y += $scale * 2) {
    for ($x = 0; $x < $w; $x += $scale) {
        $rgb = imagecolorat($img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        if ($r < 128) echo "#"; else echo " ";
    }
    echo "\n";
}
