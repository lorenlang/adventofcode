<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ([40, 50,] as $iterations) {

    $row = '3113322113';

    for ($i = 0; $i < $iterations; $i++) {
        $row = iterate($row);
    }

    output("Len for $iterations iterations: " . strlen($row));

}

function iterate($row)
{
    $output  = '';
    $digits  = str_split($row);
    $current = array_shift($digits);
    $count   = 1;
    foreach ($digits as $digit) {
        if ($digit == $current) {
            $count++;
        } else {
            $output  .= $count . $current;
            $current = $digit;
            $count   = 1;
        }
    }
    $output .= $count . $current;

    return $output;
}
