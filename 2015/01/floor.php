<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$arr = ['(' => 1, ')' => -1];

foreach ($data->rows() as $row) {
    $floor = 0;
    $chars = str_split($row);
    foreach ($chars as $char) {
        if (array_key_exists($char, $arr)) {
            $floor += $arr[$char];
        }
    }

    output($floor);
}

