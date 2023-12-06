<?php

require_once '../../functions.php';

//$data = [
//    [
//        ['time' => 7, 'distance' => 9,],
//        ['time' => 15, 'distance' => 40,],
//        ['time' => 30, 'distance' => 200,],
//    ],
//    [
//        ['time' => 71530, 'distance' => 940200,],
//    ],
//];
$data = [
    [
        ['time' => 53, 'distance' => 250,],
        ['time' => 91, 'distance' => 1330,],
        ['time' => 67, 'distance' => 1081,],
        ['time' => 68, 'distance' => 1025,],
    ],
    [
        ['time' => 53916768, 'distance' => 250133010811025,],
    ],
];


function solve($part)
{
    global $data;

    $results = [];

    foreach ($data[$part - 1] as $key => $value) {
        $results[$key] = 0;
        for ($i = 0; $i <= $value['time']; $i++) {
            $speed    = $i;
            $distance = $speed * ($value['time'] - $i);

//        output("speed: {$speed}, distance: {$distance}");

            if ($distance > $value['distance']) {
                $results[$key]++;
            }
        }
//    output('----------------------------------------');
    }

    return array_product($results);
}



output ('part 1: ' . solve(1));
output ('part 2: ' . solve(2));
