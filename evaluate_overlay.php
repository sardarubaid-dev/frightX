<?php
$img = imagecreatefrompng("storage/app/hbl_ref/overlay.png");
$w = imagesx($img);
$h = imagesy($img);

$redRows = [];
$cyanRows = [];

for ($y = 0; $y < $h; $y++) {
    $redCnt = 0;
    $cyanCnt = 0;
    for ($x = 0; $x < $w; $x++) {
        $rgb = imagecolorat($img, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        if ($r > 200 && $g < 50 && $b < 50) $redCnt++;
        if ($r < 50 && $g > 200 && $b > 200) $cyanCnt++;
        if ($r < 50 && $g < 50 && $b < 50) { // Black means exact match
            $redCnt++;
            $cyanCnt++;
        }
    }
    if ($redCnt > $w * 0.1) $redRows[] = $y;
    if ($cyanCnt > $w * 0.1) $cyanRows[] = $y;
}

function cluster($lines, $threshold = 5) {
    if (empty($lines)) return [];
    $clusters = [];
    $current = [$lines[0]];
    for ($i = 1; $i < count($lines); $i++) {
        if ($lines[$i] - end($current) <= $threshold) {
            $current[] = $lines[$i];
        } else {
            $clusters[] = round(array_sum($current) / count($current));
            $current = [$lines[$i]];
        }
    }
    $clusters[] = round(array_sum($current) / count($current));
    return $clusters;
}

$redClusters = cluster($redRows);
$cyanClusters = cluster($cyanRows);

echo "Cyan (Original) -> Red (Clone) | Difference (px)\n";
foreach ($cyanClusters as $cy) {
    $closestRed = -1;
    $minDist = 9999;
    foreach ($redClusters as $ry) {
        $d = abs($cy - $ry);
        if ($d < $minDist) {
            $minDist = $d;
            $closestRed = $ry;
        }
    }
    $diff = $closestRed - $cy; // positive means clone is below original
    $mmDiff = round($diff * 25.4 / 150, 2);
    echo "Orig $cy px  -> Clone $closestRed px | Diff: $diff px ($mmDiff mm)\n";
}
