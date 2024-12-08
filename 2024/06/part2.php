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
$rowCount = 0;

foreach ($data->rows() as $dataRow) {
    $row               = str_split($dataRow);
    $grid[$rowCount++] = $row;

    if (($pos = array_search('^', $row)) !== FALSE) {
        $current   = [$rowCount - 1, $pos];
        $direction = 'U';
    }
}

const MIN_X = 0;
const MIN_Y = 0;
define("MAX_X", count($grid[0]) - 1);
define("MAX_Y", count($grid) - 1);


function isLoop($grid, $coordinates, $current, $direction)
{
    $visited[]                              = [$current, $direction];
    $grid[$coordinates[0]][$coordinates[1]] = '#';

    while ($current[0] > MIN_Y && $current[0] < MAX_Y && $current[1] > MIN_X && $current[1] < MAX_X) {

        $next = [$current[0] + MOVE[$direction][0], $current[1] + MOVE[$direction][1]];
        if (in_array([$next, $direction], $visited, TRUE)) {
            return TRUE;
        }

        if ($grid[$next[0]][$next[1]] === '#') {
            $direction = match ($direction) {
                'U' => 'R',
                'D' => 'L',
                'L' => 'U',
                'R' => 'D',
            };
        } else {
            $current   = $next;
            $visited[] = [$current, $direction];
        }

    }


    return FALSE;
}

$total = 0;

foreach ($grid as $i => $row) {
    foreach ($row as $j => $col) {
        output("Checking [$i, $j] of [" . MAX_X . ", " . MAX_Y . "]   ::   Found so far: $total");
        if ($grid[$i][$j] === '.') {
            $add = [$i, $j];
            if (isLoop($grid, $add, $current, $direction)) {
                $total++;
            }
        }
    }
}

//var_dump(isLoop($grid, $add, $current, $direction));

//$visited = array_unique($visited, SORT_REGULAR);
output("Total: $total");
