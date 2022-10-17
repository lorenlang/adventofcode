<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;

foreach ($data->rows() as $row) {
    list($l, $w, $h) = explode('x', $row);
    $l     = (int)$l;
    $w     = (int)$w;
    $h     = (int)$h;
    $sides = [$l * $w, $w * $h, $h * $l];

    $paper = 0;
    foreach ($sides as $side) {
        $paper += 2 * $side;
    }
    $paper += min($sides);

    $total += $paper;
}

output($total);
