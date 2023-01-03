<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$heights  = array_merge(['S'], range('a', 'z'), ['E']);
$grid     = [];
$row      = 0;
$minSteps = PHP_INT_MAX;
$starts   = [];

foreach ($data->rows() as $dataRow) {

    foreach (str_split($dataRow) as $index => $char) {
        $grid[$row][$index] = $char;
        if ($char == 'S' || $char == 'a') {
            $starts[] = [$row, $index];
        }
        if ($char == 'E') {
            $dest = [$row, $index];
        }
    }
    $row++;

}

define('MAX_X', count($grid) - 1);
define('MAX_Y', count($grid[0]) - 1);

output("Possible starts: " . count($starts));
dashline();

foreach ($starts as $startNum => $start) {

    $queue   = [makeGridKey($start) => 0];
    $visited = [$start];

    // output("Max X: " . MAX_X);
    // output("Max Y: " . MAX_Y);
    // output("Start: " . makeGridKey($start));
    // output("Dest: " . makeGridKey($dest));
    // dashline();

    {
        while ( ! empty($queue)) {
            [$x, $y] = explode(',', array_key_first($queue));

            // output("testing from " . makeGridKey([$x, $y]).'   ('.$grid[$x][$y].')');

            $distance = array_shift($queue);
            // output("Distance: $distance");

            if ([$x, $y] == $dest) {
                $minSteps = min($minSteps, $distance);
                output(($startNum + 1) . ' - ' . makeGridKey($start) . " - Destination found  -  Distance: $distance  -  Min: $minSteps");
                continue 2;
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
                // if ($gridKey) {
                //     output("checking $gridKey   (".$grid[$coords[0]][$coords[1]].')');
                // }
                if ($gridKey && ( ! visited($coords, $visited)) && isReachable(array_search($grid[$x][$y], $heights),
                                                                               $coords,
                                                                               $grid, $heights)) {
                    $queue[$gridKey] = $distance + 1;
                    $visited[]       = $coords;
                }
                // dashline('20');
            }

            // output('queue count is: ' . count($queue));
            // dashline();
            // readline('waiting.....');
            // output(PHP_EOL);
        }
    }
}

output(PHP_EOL);
dashline();
output("Minimum steps: $minSteps");
dashline();
output(PHP_EOL);


function makeGridKey(array $coords)
{
    return ($coords[0] < 0 || $coords[1] < 0 || $coords[0] > MAX_X || $coords[1] > MAX_Y) ? FALSE : join(',', $coords);
}


function visited(array $coords, array &$visited)
{
    // output(in_array($coords, $visited) ? 'Already visited' : 'Not visited yet');

    return in_array($coords, $visited);
}


function isReachable(int $current, array $coords, array &$grid, array &$heights)
{
    $x = $coords[0];
    $y = $coords[1];

    // $output[] = "$current -> " . array_search($grid[$x][$y], $heights);
    // $output[] = (isset($grid[$x][$y]) && array_search($grid[$x][$y],
    //                                                   $heights) >= $current && (array_search($grid[$x][$y],
    //                                                                                          $heights) - $current <= 1)) ? 'Reachable' : 'Not Reachable';
    // output(join('    ', $output));

    // return (isset($grid[$x][$y]) && array_search($grid[$x][$y], $heights) >= $current && (array_search($grid[$x][$y],
    return (isset($grid[$x][$y]) && (array_search($grid[$x][$y], $heights) - $current <= 1));
}
