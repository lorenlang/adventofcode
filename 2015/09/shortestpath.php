<?php

use Utility\FileReader;
use Utility\PermutationsGenerator;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../utility/PermutationsGenerator.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$cities  = [];
$mileage = [];
$totals  = [];

foreach ($data->rows() as $row) {
    list($city1, $city2, $miles) = parseRoute($row);
    $cities[]                = $city1;
    $cities[]                = $city2;
    $mileage[$city1][$city2] = $miles;
    $mileage[$city2][$city1] = $miles;
}

$cities = array_unique($cities);

$routes = new PermutationsGenerator($cities);
foreach ($routes as $route) {
    $total = 0;
    for ($i = 1; $i < count($route); $i++) {
        $total += $mileage[$route[$i - 1]][$route[$i]];
    }
    $totals[] = $total;
}

output('Min: ' .min($totals).'   Max: ' .max($totals));



function parseRoute($route)
{
    list($cities, $miles) = explode('=', $route);
    list($city1, $city2) = explode('to', $cities);

    return [trim($city1), trim($city2), (int)trim($miles)];
}
