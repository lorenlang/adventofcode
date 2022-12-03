<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$outcome = [
    'A' => ['X' => 'D', 'Y' => 'W', 'Z' => 'L',],
    'B' => ['X' => 'L', 'Y' => 'D', 'Z' => 'W',],
    'C' => ['X' => 'W', 'Y' => 'L', 'Z' => 'D',],
];
$points  = ['X' => 1, 'Y' => 2, 'Z' => 3, 'W' => 6, 'L' => 0, 'D' => 3,];

$score = 0;

foreach ($data->rows() as $dataRow) {

    [$opp, $plyr] = explode(' ', $dataRow);
    $score += $points[$outcome[$opp][$plyr]] + $points[$plyr];

}

output("Total: " . $score);
