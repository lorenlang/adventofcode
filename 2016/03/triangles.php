<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$count = 0;
foreach ($data->rows() as $row) {
    // output($row);
    // print_r(explode(' ', str_replace(['    ','   ','  '], ' ', $row)));
    if (isValid(explode(' ', str_replace(['    ','   ','  '], ' ', $row)))) {
        $count++;
    }
}

output("Count: $count");


function isValid(array $sides)
{
    return (($sides[0] + $sides[1] > $sides[2]) && ($sides[2] + $sides[1] > $sides[0]) && ($sides[0] + $sides[2] > $sides[1]));
}
