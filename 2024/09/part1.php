<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$fileId = 0;
$blocks = [];
$nulls = [];
$files = [];

foreach ($data->rows() as $dataRow) {
    $row = str_split($dataRow);
}

foreach ($row as $key => $item) {
    for ($i = 0; $i < $item; $i++) {
        $blocks[] = isEven($key) ? $fileId : NULL;
    }
    $fileId += isEven($key) ? 1 : 0;
}

foreach ($blocks as $key => $block) {
    if ($block === NULL) {
        $nulls[] = $key;
    } else {
        $files[] = $key;
    }
}

$file = array_pop($files);
$null = array_shift($nulls);

while ($null < $file) {
    $blocks = array_swap($blocks, $null, $file);
    $file = array_pop($files);
    $null = array_shift($nulls);
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


function array_swap($array, $swap1, $swap2) {
    $temp = $array[$swap1];
    $array[$swap1] = $array[$swap2];
    $array[$swap2] = $temp;
    return $array;
}

function printit($blocks) {
    $output = '';
    foreach ($blocks as $key => $block) {
        $output .= $block === NULL ? '.' : $block;
    }
    return $output;
}
