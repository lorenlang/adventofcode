<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;
foreach ($data->rows() as $dataRow) {

    preg_match_all('/mul\((\d\d?\d?),(\d\d?\d?)\)/', $dataRow, $matches);

    foreach ($matches[1] as $key => $match) {
        $total += $match * $matches[2][$key];
    }
}

output("Total: $total");

