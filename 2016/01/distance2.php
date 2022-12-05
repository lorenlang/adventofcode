<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

// require_once 'test.php';
require_once 'data.php';

$dir    = 'N';
$row    = 0;
$col    = 0;
$blocks = [];

$directions = explode(', ', $data);

foreach ($directions as $direction) {
    $chars    = str_split($direction);
    $turn     = array_shift($chars);
    $distance = (int)join('', $chars);

    switch ([$dir, $turn]) {
        case ['N', 'L']:
            $dir = 'W';
            break;
        case ['N', 'R']:
            $dir = 'E';
            break;
        case ['S', 'L']:
            $dir = 'E';
            break;
        case ['S', 'R']:
            $dir = 'W';
            break;
        case ['E', 'L']:
            $dir = 'N';
            break;
        case ['E', 'R']:
            $dir = 'S';
            break;
        case ['W', 'L']:
            $dir = 'S';
            break;
        case ['W', 'R']:
            $dir = 'N';
            break;
    }

    for ($i = 0; $i < $distance; $i++) {
        switch ($dir) {
            case 'N':
                $col++;
                break;
            case 'S':
                $col--;
                break;
            case 'E':
                $row++;
                break;
            case 'W':
                $row--;
                break;
        }

        if (in_array("$row|$col", $blocks)) {
            output('Distance: ' . (abs($row) + abs($col)));
            die();
        } else {
            $blocks[] = "$row|$col";
        }
    }

}

