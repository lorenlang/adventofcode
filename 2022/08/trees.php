<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

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
        $miny    = min($miny, $j);
        $maxy    = max($maxy, $j);
        $trees[] = [
            'x' => $i,
            'y' => $j,
            'h' => $lines[$i][$j],
        ];
    }
}


$possible = array_filter($trees, function ($tree) use ($minx, $maxx, $miny, $maxy) {
    return $tree['x'] > $minx && $tree['x'] < $maxx && $tree['y'] > $miny && $tree['y'] < $maxy;
});

$visible = count($trees) - count($possible);
$maxScenic = PHP_INT_MIN;

foreach ($possible as $tree) {

    $neighbors = array_filter($trees, function ($item) use ($tree) {
        if ($item['x'] == $tree['x'] && $item['y'] == $tree['y']) {
            return FALSE;
        }

        return $item['x'] == $tree['x'] || $item['y'] == $tree['y'];

    });

    $up = array_filter($neighbors, function ($item) use ($tree) {
        return $item['x'] < $tree['x'] && $item['h'] >= $tree['h'];
    });
    $dn = array_filter($neighbors, function ($item) use ($tree) {
        return $item['x'] > $tree['x'] && $item['h'] >= $tree['h'];
    });
    $lt = array_filter($neighbors, function ($item) use ($tree) {
        return $item['y'] < $tree['y'] && $item['h'] >= $tree['h'];
    });
    $rt = array_filter($neighbors, function ($item) use ($tree) {
        return $item['y'] > $tree['y'] && $item['h'] >= $tree['h'];
    });

    if (count($up) == 0 || count($dn) == 0 || count($lt) == 0 || count($rt) == 0) {
        $visible++;
    }

}

output("Visible: $visible");
