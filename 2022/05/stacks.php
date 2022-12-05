<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$testMode = FALSE;

if ($testMode) {
    $data   = new FileReader(currentDir('test.txt'));
    $stacks = [
        1 => ['N', 'Z',],
        2 => ['D', 'C', 'M',],
        3 => ['P',],
    ];
} else {
    $data   = new FileReader(currentDir('data.txt'));
    $stacks = [
        1 => ['N', 'H', 'S', 'J', 'F', 'W', 'T', 'D',],
        2 => ['G', 'B', 'N', 'T', 'Q', 'P', 'R', 'H',],
        3 => ['V', 'Q', 'L',],
        4 => ['Q', 'R', 'W', 'S', 'B', 'N',],
        5 => ['B', 'M', 'V', 'T', 'F', 'D', 'N',],
        6 => ['R', 'T', 'H', 'V', 'B', 'D', 'M',],
        7 => ['J', 'Q', 'B', 'D',],
        8 => ['Q', 'H', 'Z', 'R', 'V', 'J', 'N', 'D',],
        9 => ['S', 'M', 'H', 'N', 'B',],
    ];
}

foreach ($data->rows() as $dataRow) {
    [,$qty,,$src,,$dst] = explode(' ',$dataRow);
    for ($i = 0; $i < $qty; $i++) {
        array_unshift($stacks[$dst], array_shift($stacks[$src]));
    }
}

$output = '';
foreach ($stacks as $stack){
    $output .= $stack[0];
}


output("Part 1: " . $output);
// output("Part 2 total: " . $total2);
