<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total1 = 0;
$total2 = 0;

foreach ($data->rows() as $dataRow) {

    [$one, $two] = explode(',', $dataRow);
    [$x1, $y1] = explode('-', $one);
    [$x2, $y2] = explode('-', $two);

    if (($x1 >= $x2 && $y1 <= $y2) || ($x2 >= $x1 && $y2 <= $y1)) {
        $total1++;
    }

    $arr1 = range($x1, $y1);
    $arr2 = range($x2, $y2);
    if (count(array_intersect($arr1, $arr2)) > 0) {
        $total2++;
    }

}

output("Part 1 total: " . $total1);


output("Part 2 total: " . $total2);
