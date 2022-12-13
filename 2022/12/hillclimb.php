<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

$grid = [];
$row  = 0;

foreach ($data->rows() as $dataRow) {

    foreach (str_split($dataRow) as $index => $char) {
        $grid[$row][$index] = $char;
        if ($char == 'S') {
            $start = "$row|$index";
        }
        if ($char == 'E') {
            $end = "$row|$index";
        }
    }
    $row++;

}
draw($grid);
// output("Total: $total");
output("Start: $start");
output("  End: $end");


function draw($grid)
{
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            echo $grid[$i][$j];
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
    echo PHP_EOL;
}
