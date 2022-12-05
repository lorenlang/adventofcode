<?php

require_once '../../autoload.php';
require_once '../../functions.php';

define('FAVE', 1358);
$dest    = [31, 39];
$start   = [1, 1];
$queue   = [makeGridKey($start) => 0];
$visited = [$start];
$count   = 1;


while ( ! empty($queue)) {
    [$x, $y] = explode(',', array_key_first($queue));
    $distance = array_shift($queue);

    if ([$x, $y] == $dest) {
        output("Distance: $distance");
        output("Count: $count");
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
        if ($gridKey && ( ! visited($coords, $visited)) && isOpen($coords)) {
            $queue[$gridKey] = $distance + 1;
            $visited[]       = $coords;
            if ($distance + 1 <= 50) {
                $count++;
            }
        }
    }

}

output('Destination not found');

function countOnes(int $num)
{
    $count = 0;
    while ($num !== 0) {
        $count++;
        $num = $num & ($num - 1);
    }

    return $count;
}


function makeGridKey(array $coords)
{
    return ($coords[0] < 0 || $coords[1] < 0) ? FALSE : join(',', $coords);
}


function visited(array $coords, array $visited)
{
    return in_array($coords, $visited);
}


function isOpen(array $coords)
{
    $x        = $coords[0];
    $y        = $coords[1];
    $checkNum = ($x * $x) + (3 * $x) + (2 * $x * $y) + $y + ($y * $y) + FAVE;

    return countOnes($checkNum) % 2 === 0;
}
