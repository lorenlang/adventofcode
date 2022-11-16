<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$code   = '';
$keypad = [[1, 2, 3], [4, 5, 6], [7, 8, 9]];
$row    = 1;
$col    = 1;

foreach ($data->rows() as $dataRow) {

    $chars = str_split($dataRow);
    foreach ($chars as $char) {
        switch ($char) {
            case 'U':
                $row = max(0, $row - 1);
                break;
            case 'D':
                $row = min(2, $row + 1);
                break;
            case 'L':
                $col = max(0, $col - 1);
                break;
            case 'R':
                $col = min(2, $col + 1);
                break;
        }
    }

    $code .= $keypad[$row][$col];

}


output("Code: $code");
