<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$packets  = [];
$total    = 0;
$dividers = ['[[2]]', '[[6]]',];

foreach ($data->rows() as $dataRow) {
    $packets[] = json_decode($dataRow);
}
foreach ($dividers as $divider) {
    $packets[] = json_decode($divider);
}

for ($i = 0; $i < count($packets) - 1; $i++) {
    for ($j = $i + 1; $j < count($packets); $j++) {

        $left  = $packets[$i];
        $right = $packets[$j];

        if (compare($left, $right) === -1) {
            $hold        = $packets[$i];
            $packets[$i] = $packets[$j];
            $packets[$j] = $hold;
        }

    }
}

$encoded = [];
foreach ($packets as $packet) {
    $encoded[] = json_encode($packet);
}

$indices = [];
foreach ($dividers as $divider) {
    $indices[] = array_search($divider, $encoded) + 1;
}

output("Decoder key: ". array_product($indices));


function compare($left, $right): int
{
    if (bothNumeric($left, $right)) {
        return compareIntegers($left, $right);
    }

    [$left, $right] = makeArrays($left, $right);

    return compareArrays($left, $right);
}


function compareArrays($left, $right): int
{
    while ( ! empty($left) && ! empty($right)) {
        $leftItem  = array_shift($left);
        $rightItem = array_shift($right);
        $result    = compare($leftItem, $rightItem);
        if ($result !== 0) {
            return $result;
        }
    }
    if (empty($left) && empty($right)) {
        return 0;
    } else if (empty($left)) {
        return 1;
    } else {
        return -1;
    }
}


function compareIntegers($left, $right): int
{
    if ($left < $right) {
        return 1;
    } else if ($left > $right) {
        return -1;
    } else {
        return 0;
    }
}


function bothNumeric($left, $right): bool
{
    return is_numeric($left) && is_numeric($right);
}


function makeArrays($left, $right): array
{
    if ( ! is_array($left)) {
        $left = [$left];
    }
    if ( ! is_array($right)) {
        $right = [$right];
    }

    return [$left, $right];
}
