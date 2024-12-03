<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$total        = 0;
$instructions = [];
$fullData     = '';
foreach ($data->rows() as $dataRow) {
    $fullData .= $dataRow;
}

preg_match_all('/mul\((\d\d?\d?),(\d\d?\d?)\)/', $fullData, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $key => $match) {
    $instructions[$match[1]] = [$matches[1][$key][0], $matches[2][$key][0]];
}

preg_match_all('/do\(\)/', $fullData, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $key => $match) {
    $instructions[$match[1]] = 'enable';
}

preg_match_all('/don\'t\(\)/', $fullData, $matches, PREG_OFFSET_CAPTURE);

foreach ($matches[0] as $key => $match) {
    $instructions[$match[1]] = 'disable';
}


ksort($instructions);
$enabled = TRUE;

foreach ($instructions as $key => $instruction) {
    if ($instruction === 'enable') {
        $enabled = TRUE;
    } else if ($instruction === 'disable') {
        $enabled = FALSE;
    } else if ($enabled) {
        $total += $instruction[0] * $instruction[1];
    }
}

output("Total: $total");

