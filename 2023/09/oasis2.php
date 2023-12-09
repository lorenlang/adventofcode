<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$sum  = 0;

foreach ($data->rows() as $dataRow) {
    $work = [];

    $dataRow = explode(' ', $dataRow);
    $work[]  = array_reverse($dataRow);

    while (count(array_unique($work[max(array_keys($work))])) > 1) {
        $work[] = calcNextRow($work[max(array_keys($work))]);
    }

    $add = 0;
    foreach ($work as $values) {
        $add += end($values);
    }
    $sum += $add;

}

output("Sum: $sum");


function calcNextRow($row)
{
    $nextRow = [];
    for ($i = 0; $i < count($row) - 1; $i++) {
        $nextRow[] = $row[$i+1] - $row[$i];
    }

    return $nextRow;
}

