<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../utility/PermutationsGenerator.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    $current = json_decode($row);
    output("Total: " . parse($current));
}


function parse($current)
{
    $total = 0;

    foreach ($current as $item) {

        if (is_array($item) || is_object($item)) {
            $total += parse($item);
        }
        if (is_numeric($item)) {
            $total += $item;
        }
        if (is_object($current) && is_string($item) && $item == 'red') {
            return FALSE;
        }

    }

    return $total;
}
