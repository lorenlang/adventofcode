<?php


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));


$x      = 1;
$cycle  = 0;
$values = [];
$checks = [20, 60, 100, 140, 180, 220,];

foreach ($data->rows() as $dataRow) {

    if ($dataRow == 'noop') {
        $cycle++;
        $values[$cycle] = $x;
    } else if (substr($dataRow, 0, 4) == 'addx') {
        [, $val] = explode(' ', $dataRow);
        for ($i = 0; $i < 2; $i++) {
            $cycle++;
            $values[$cycle] = $x;
        }
        $x += $val;
    } else {
        die("FATAL ERROR: Unrecognized command :: $dataRow");
    }

    $values[$cycle . '!'] = $x;
}

$total = 0;
foreach ($checks as $check) {
    $total += $check * $values[$check];
}

output("Total: $total");
