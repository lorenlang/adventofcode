<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
//$data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));


$firstRow = FALSE;
$elements = [];

foreach ($data->rows() as $dataRow) {
    if ($firstRow === FALSE) {
        $map      = str_split($dataRow);
        $firstRow = TRUE;
        continue;
    }

    $dataRow = str_replace(['(', ')', ',', '= '], '', $dataRow);
    [$key, $left, $right] = explode(' ', $dataRow);
    $elements[$key] = ['L' => $left, 'R' => $right];
}

$current = 'AAA';
$steps   = 0;

do {
    foreach ($map as $direction) {
        $steps++;
        $current = $elements[$current][$direction];
        if ($current === 'ZZZ') {
            output("Found ZZZ in $steps steps");
            break 2;
        }
            }
} while ($current !== 'ZZZ');



//output("Total is: " . array_sum($points));

