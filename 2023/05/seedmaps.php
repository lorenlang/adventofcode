<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$seeds = [];
$maps = [];
$results = [];
$activeMap = null;

foreach ($data->rows() as $dataRow) {

    if (stripos($dataRow, 'seeds: ') === 0) {
        $seeds = explode(' ', $dataRow);
        array_shift($seeds);
    } elseif (strtolower(substr($dataRow, -5)) === ' map:') {
        $activeMap = explode(' ', $dataRow)[0];
        $maps[$activeMap] = [];
    } else {
        [$destination, $source, $num] = explode(' ', $dataRow);
        $maps[$activeMap][] = ['min' => $source, 'max' => $source + $num, 'base' => $destination];
    }
}

// for each maps sort by the keys
//foreach ($maps as $map => $mapData) {
//    ksort($mapData);
//    $maps[$map] = $mapData;
//}

foreach ($seeds as $seed) {
    $results[] = lookup('humidity-to-location', lookup('temperature-to-humidity', lookup('light-to-temperature', lookup('water-to-light', lookup('fertilizer-to-water', lookup('soil-to-fertilizer', lookup('seed-to-soil', $seed)))))));
//    $results[] = lookup('seed-to-soil', $seed);
}

//print_r($results);
output("Minimum: " . min($results));


function lookup($map, $key)
{
    global $maps;
    foreach ($maps[$map] as $mapData) {
        if ($key >= $mapData['min'] && $key < $mapData['max']) {
            return $mapData['base'] + ($key - $mapData['min']);
        }
    }
    return $key;
}
