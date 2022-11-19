<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

define('GRIDROWS', 6);
define('GRIDCOLS', 50);

$grid = initGrid();

foreach ($data->rows() as $row) {

    output($row);
    [$command, $parms] = explode(' ', $row, 2);
    switch ($command) {
        case 'rect':
            $grid = rectangle($grid, $parms);
            break;
        case 'rotate':
            [$direction, $index, , $qty] = explode(' ', $parms);
            if ($direction == 'row') {
                $grid = shiftRow($grid, $index, $qty);
            } else if ($direction == 'column') {
                $grid = shiftCol($grid, $index, $qty);
            }
            break;
    }

}
displayGrid($grid);

$count = 0;
foreach ($grid as $row) {
    $count += array_sum($row);
}

output("Count: $count");


function initGrid()
{
    for ($row = 0; $row < GRIDROWS; $row++) {
        for ($col = 0; $col < GRIDCOLS; $col++) {
            $grid[$row][$col] = '0';
        }
    }

    return $grid;
}


function displayGrid($grid)
{
    foreach ($grid as $i => $row) {
        echo "   ";
        foreach ($row as $j => $col) {
            // echo "$j ";
            echo $col;
        }
        echo PHP_EOL;
    }
}


function rectangle($grid, $dims)
{
    [$x, $y] = explode('x', $dims);

    for ($row = 0; $row < $y; $row++) {
        for ($col = 0; $col < $x; $col++) {
            $grid[$row][$col] = '1';
        }
    }

    return $grid;
}


function shiftRow($grid, $row, $qty)
{
    $row = substr($row, 2);

    for ($i = 0; $i < $qty; $i++) {

        $hold = $grid[$row][count($grid[$row]) - 1];
        for ($j = count($grid[$row]) - 2; $j >= 0; $j--) {
            $grid[$row][$j + 1] = $grid[$row][$j];
        }
        $grid[$row][0] = $hold;

    }

    return $grid;
}


function shiftCol($grid, $col, $qty)
{
    $col = substr($col, 2);

    for ($i = 0; $i < $qty; $i++) {

        $hold = $grid[count($grid) - 1][$col];
        for ($j = count($grid) - 2; $j >= 0; $j--) {
            $grid[$j + 1][$col] = $grid[$j][$col];
        }
        $grid[0][$col] = $hold;

    }

    return $grid;
}
