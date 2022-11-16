<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

require_once 'test.php';
// require_once 'data.php';

$dir = 'N';
$row = 0;
$col = 0;

$directions = explode(', ', $data);

foreach ($directions as $direction) {
    $chars    = str_split($direction);
    $turn     = array_shift($chars);
    $distance = (int)join('', $chars);

    switch ([$dir, $turn]) {
        case ['N', 'L']:
            $dir = 'W';
            $col -= $distance;
            break;
        case ['N', 'R']:
            $dir = 'E';
            $col += $distance;
            break;
        case ['S', 'L']:
            $dir = 'E';
            $col += $distance;
            break;
        case ['S', 'R']:
            $dir = 'W';
            $col -= $distance;
            break;
        case ['E', 'L']:
            $dir = 'N';
            $row += $distance;
            break;
        case ['E', 'R']:
            $dir = 'S';
            $row -= $distance;
            break;
        case ['W', 'L']:
            $dir = 'S';
            $row -= $distance;
            break;
        case ['W', 'R']:
            $dir = 'N';
            $row += $distance;
            break;
    }

}

output('Distance: ' . (abs($row) + abs($col)));
