<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$calories = 0;
$totals   = [];
$top3     = [];

foreach ($data->rows(TRUE) as $dataRow) {

    if (empty($dataRow)) {
        $totals[] = $calories;
        $calories = 0;
    } else {
        $calories += (int)$dataRow;
    }

}

output("Max: " . max($totals));

sort($totals);
$top3 = [
    array_pop($totals),
    array_pop($totals),
    array_pop($totals),
];

output('Top 3: ' . array_sum($top3));
