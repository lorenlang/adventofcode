<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$work = [];

foreach ($data->rows() as $ctr => $row) {
    $values = explode(' ', str_replace(['    ', '   ', '  '], ' ', $row));
    foreach ($values as $index => $value) {
        $work[(floor($ctr / 3) * 3) + $index][$ctr % 3] = $value;
    }
}

$count = 0;
foreach ($work as $item) {
    if (isValid($item)) {
        $count++;
    }
}


output("Count: $count");


function isValid(array $sides)
{
    return (($sides[0] + $sides[1] > $sides[2]) && ($sides[2] + $sides[1] > $sides[0]) && ($sides[0] + $sides[2] > $sides[1]));
}
