<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

const MOVE = [
    'U' => [-1, 0],
    'D' => [1, 0],
    'L' => [0, -1],
    'R' => [0, 1],
];

$grid     = [];
$visited  = [];
$rowCount = 0;

foreach ($data->rows() as $dataRow) {
    $row               = str_split($dataRow);
    $grid[$rowCount++] = $row;

    if (($pos = array_search('^', $row)) !== FALSE) {
        $current   = [$rowCount - 1, $pos];
        $visited[] = $current;
        $direction = 'U';
    }
}

$minX = 0;
$maxX = count($grid[0]) - 1;
$minY = 0;
$maxY = count($grid) - 1;

$grid[$current[0]][$current[1]] = 'O';

while ($current[0] > $minY && $current[0] < $maxY && $current[1] > $minX && $current[1] < $maxX) {

    $next = [$current[0] + MOVE[$direction][0], $current[1] + MOVE[$direction][1]];
    if ($grid[$next[0]][$next[1]] === '#') {
        $direction = match ($direction) {
            'U' => 'R',
            'D' => 'L',
            'L' => 'U',
            'R' => 'D',
        };
    } else {
        $current = $next;
        $visited[] = $current;
        $grid[$current[0]][$current[1]] = 'O';
    }

}

$visited = array_unique($visited, SORT_REGULAR);
output("Total: " . count($visited));
