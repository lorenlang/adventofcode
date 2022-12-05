<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$code   = '';
$keypad = [
    ['', '', '1', '', ''],
    ['', '2', '3', '4', ''],
    ['5', '6', '7', '8', '9'],
    ['', 'A', 'B', 'C', ''],
    ['', '', 'D', '', ''],
];
$row    = 2;
$col    = 0;

foreach ($data->rows() as $dataRow) {

    $chars = str_split($dataRow);
    foreach ($chars as $char) {
        switch ($char) {
            case 'U':
                $newRow = max(0, $row - 1);
                $newCol = $col;
                break;
            case 'D':
                $newRow = min(4, $row + 1);
                $newCol = $col;
                break;
            case 'L':
                $newCol = max(0, $col - 1);
                $newRow = $row;
                break;
            case 'R':
                $newCol = min(4, $col + 1);
                $newRow = $row;
                break;
        }
        if ( ! empty($keypad[$newRow][$newCol])) {
            $row = $newRow;
            $col = $newCol;
        }
    }

    $code .= $keypad[$row][$col];

}


output("Code: $code");
