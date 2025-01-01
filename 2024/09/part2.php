<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$fileId = 0;
$blocks = [];
$nulls  = [];
$files  = [];

foreach ($data->rows() as $dataRow) {
    $row = str_split($dataRow);
}

foreach ($row as $key => $item) {
    if (isEven($key)) {
        $files[] = ['index' => count($blocks), 'length' => $item];
    } else {
        $nulls[] = ['index' => count($blocks), 'length' => $item];
    }

    for ($i = 0; $i < $item; $i++) {
        $blocks[] = isEven($key) ? $fileId : NULL;
    }
    $fileId += isEven($key) ? 1 : 0;
}


while ($file = array_pop($files)) {
    foreach ($nulls as $nullPtr => $null) {
        if ($null['length'] <= 0) {
            unset($nulls[$nullPtr]);
            continue;
        }
        if ($null['length'] >= $file['length']) {
            if ($null['index'] < $file['index']) {
                for ($i = 0; $i < $file['length']; $i++) {
                    $blocks                    = array_swap($blocks, $null['index'] + $i, $file['index'] + $i);
                    $nulls[$nullPtr]['index']  += 1;
                    $nulls[$nullPtr]['length'] -= 1;
                }
            }
            break;
        }
    }
}

output("Checksum: " . getChecksum($blocks));


function getChecksum(mixed $blocks): int
{
    $checksum = 0;
    foreach ($blocks as $key => $block) {
        $checksum += $block * $key;
    }
    return $checksum;
}


function array_swap($array, $swap1, $swap2)
{
    $temp          = $array[$swap1];
    $array[$swap1] = $array[$swap2];
    $array[$swap2] = $temp;
    return $array;
}

function printit($blocks)
{
    $output = '';
    foreach ($blocks as $key => $block) {
        $output .= $block === NULL ? '.' : $block;
    }
    return $output;
}
