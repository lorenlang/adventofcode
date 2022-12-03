<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$outcome = [
    'A' => ['X' => 'S', 'Y' => 'R', 'Z' => 'P',],
    'B' => ['X' => 'R', 'Y' => 'P', 'Z' => 'S',],
    'C' => ['X' => 'P', 'Y' => 'S', 'Z' => 'R',],
];
$points  = ['R' => 1, 'P' => 2, 'S' => 3, 'Z' => 6, 'X' => 0, 'Y' => 3,];

$score = 0;

foreach ($data->rows() as $dataRow) {

    [$opp, $plyr] = explode(' ', $dataRow);
    $score += $points[$outcome[$opp][$plyr]] + $points[$plyr];

}

output("Total: " . $score);
