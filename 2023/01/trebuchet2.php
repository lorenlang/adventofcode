<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;

$srch = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',];
$repl = ['o1e', 't2o', 't3e', 'f4r', 'f5e', 's6x', 's7n', 'e8t', 'n9e',];

foreach ($data->rows() as $dataRow) {

    $matches = [];
    do {
        foreach ($srch as $index => $str) {
            $matches[$index] = strpos($dataRow, $str);
        }

        $matches = array_filter($matches, function ($val) {
            return is_numeric($val);
        });

        if (!empty($matches)) {
            $minPos = min($matches);
            $minKey = array_search($minPos, $matches, TRUE);
            $dataRow = str_replace($srch[$minKey], $repl[$minKey], $dataRow);
        }

    } while (!empty($matches));

    $digits = preg_replace("/[^0-9]/", "", $dataRow);
    $firstLast = (int)($digits[0] . $digits[strlen($digits) - 1]);
    $total += $firstLast;
}

echo $total . PHP_EOL;
