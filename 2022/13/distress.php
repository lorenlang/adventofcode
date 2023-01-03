<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$pairs = [];
$index = 1;
$total = 0;

foreach ($data->rows(TRUE) as $dataRow) {
    if (empty($dataRow)) {
        $index++;
    } else {
        $pairs[$index][] = json_decode($dataRow);
    }
}


foreach ($pairs as $index => $pair) {
    $left  = $pair[0];
    $right = $pair[1];

    if (compare($left, $right) === 1) {
        $total += $index;
    }
}

output("Total: $total");


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
        $result = compare($leftItem, $rightItem);
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
