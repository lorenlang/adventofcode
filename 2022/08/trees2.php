<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$minx  = PHP_INT_MAX;
$maxx  = PHP_INT_MIN;
$miny  = PHP_INT_MAX;
$maxy  = PHP_INT_MIN;
$trees = [];

foreach ($data->rows() as $dataRow) {
    $lines[] = $dataRow;
}

for ($i = 0; $i < count($lines); $i++) {
    $minx = min($minx, $i);
    $maxx = max($maxx, $i);
    for ($j = 0; $j < strlen($dataRow); $j++) {
        $miny          = min($miny, $j);
        $maxy          = max($maxy, $j);
        $trees[$i][$j] = $lines[$i][$j];
    }
}


$maxScenic = PHP_INT_MIN;


for ($i = $minx; $i <= $maxx; $i++) {
    for ($j = $miny; $j <= $maxy; $j++) {

        $up = 0;
        for ($x = $i - 1; $x >= $minx; $x--) {
            $up++;
            if ($trees[$x][$j] >= $trees[$i][$j]) {
                break;
            }
        }

        $dn = 0;
        for ($x = $i + 1; $x <= $maxx; $x++) {
            $dn++;
            if ($trees[$x][$j] >= $trees[$i][$j]) {
                break;
            }
        }

        $lt = 0;
        for ($y = $j - 1; $y >= $miny; $y--) {
            $lt++;
            if ($trees[$i][$y] >= $trees[$i][$j]) {
                break;
            }
        }

        $rt = 0;
        for ($y = $j + 1; $y <= $maxy; $y++) {
            $rt++;
            if ($trees[$i][$y] >= $trees[$i][$j]) {
                break;
            }
        }

        output("$i,$j  -  $up | $dn | $rt | $lt");

        $scenic    = $up * $dn * $lt * $rt;
        $maxScenic = max($maxScenic, $scenic);

    }
}


output("Scenic: $maxScenic");
