<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data  = new FileReader(currentDir('test.txt'));
// $steps = 5;
$data  = new FileReader(currentDir('data.txt'));
$steps = 100;


$grid = [];
foreach ($data->rows() as $num => $row) {
    foreach (str_split($row) as $key => $val) {
        $grid[$num][$key] = ['curr' => $val == '.' ? 0 : 1, 'next' => 0];
    }
}
setCorners($grid, 'curr');
setCorners($grid, 'next');

draw($grid);
for ($step = 0; $step < $steps; $step++) {
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            if ($grid[$i][$j]['curr'] && (tallyNeighbors($grid, $i, $j) == 2 || tallyNeighbors($grid, $i, $j) == 3)) {
                $grid[$i][$j]['next'] = 1;
            }

            if (( ! $grid[$i][$j]['curr']) && tallyNeighbors($grid, $i, $j) == 3) {
                $grid[$i][$j]['next'] = 1;
            }
        }
    }
    nextStep($grid);
    draw($grid);
}

output(tallyAll($grid));


function tallyNeighbors($grid, $row, $col)
{
    $count = 0;
    for ($i = $row - 1; $i <= $row + 1; $i++) {
        for ($j = $col - 1; $j <= $col + 1; $j++) {
            if (isset($grid[$i][$j]) && ! ($i == $row && $j == $col)) {
                $count += $grid[$i][$j]['curr'];
            }
        }
    }

    return $count;
}


function tallyAll($grid)
{
    $count = 0;
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            $count += $grid[$i][$j]['curr'];
        }
    }

    return $count;
}


function nextStep(&$grid)
{
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            $grid[$i][$j]['curr'] = $grid[$i][$j]['next'];
            $grid[$i][$j]['next'] = 0;
        }
    }
    setCorners($grid, 'next');
}


function setCorners(&$grid, $context)
{
    $max                        = count($grid) - 1;
    $grid[0][0][$context]       = 1;
    $grid[0][$max][$context]    = 1;
    $grid[$max][0][$context]    = 1;
    $grid[$max][$max][$context] = 1;
}


function draw($grid)
{
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[$i]); $j++) {
            echo $grid[$i][$j]['curr'] ? '#' : '.';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
    echo PHP_EOL;
}
