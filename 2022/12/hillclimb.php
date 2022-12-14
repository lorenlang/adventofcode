<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$heights = array_merge(['S'], range('a', 'z'), ['E']);
$grid    = [];
$row     = 0;

foreach ($data->rows() as $dataRow) {

    foreach (str_split($dataRow) as $index => $char) {
        $grid[$row][$index] = $char;
        if ($char == 'S') {
            $start = [$row, $index];
        }
        if ($char == 'E') {
            $dest = [$row, $index];
        }
    }
    $row++;

}

define('MAX_X', count($grid) - 1);
define('MAX_Y', count($grid[0]) - 1);

$queue   = [makeGridKey($start) => 0];
$visited = [$start];

while ( ! empty($queue)) {
    [$x, $y] = explode(',', array_key_first($queue));

    $distance = array_shift($queue);

    if ([$x, $y] == $dest) {
        output(PHP_EOL);
        dashline();
        output("Destination found!");
        output("Distance: $distance");
        dashline();
        output(PHP_EOL);
        die();
    }

    foreach (
        [
            [$x - 1, $y],
            [$x + 1, $y],
            [$x, $y - 1],
            [$x, $y + 1],
        ] as $coords
    ) {

        $gridKey = makeGridKey($coords);
        if ($gridKey && ( ! visited($coords, $visited)) && isReachable(array_search($grid[$x][$y], $heights), $coords,
                                                                       $grid, $heights)) {
            $queue[$gridKey] = $distance + 1;
            $visited[]       = $coords;
        }
    }

}


function makeGridKey(array $coords)
{
    return ($coords[0] < 0 || $coords[1] < 0 || $coords[0] > MAX_X || $coords[1] > MAX_Y) ? FALSE : join(',', $coords);
}


function visited(array $coords, array &$visited)
{
    return in_array($coords, $visited);
}


function isReachable(int $current, array $coords, array &$grid, array &$heights)
{
    $x = $coords[0];
    $y = $coords[1];

    return (isset($grid[$x][$y]) && (array_search($grid[$x][$y], $heights) - $current <= 1));
}
