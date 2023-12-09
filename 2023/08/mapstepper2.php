<?php

// NOTE: I ended up seeing that there was a repeating pattern for all of the starts and that the answer would be the
//       lowest common multiple of the steps for each start.  I used an online caluculator to find the LCM

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test3.txt'));
$data = new FileReader(currentDir('data.txt'));


$firstRow = FALSE;
$elements = [];
$starts   = [];
$ends     = [];

foreach ($data->rows() as $dataRow) {
    if ($firstRow === FALSE) {
        $map      = str_split($dataRow);
        $firstRow = TRUE;
        continue;
    }

    $dataRow = str_replace(['(', ')', ',', '= '], '', $dataRow);
    [$key, $left, $right] = explode(' ', $dataRow);
    $elements[$key] = ['L' => $left, 'R' => $right];
    if (substr($key, -1) === 'A') {
        $starts[] = $key;
    }
}

output("Number of starts: " . count($starts));

$ctr      = 0;
$maxSteps = 200000000000;
foreach ($starts as $start) {
    $ctr++;
    output("Start $ctr: $start");
    $current = $start;
    $steps   = 0;
    do {
        foreach ($map as $direction) {
            $steps++;
            $current = $elements[$current][$direction];
            if (substr($current, -1) === 'Z') {
                $ends[$start][] = $steps;
//                output("Found end $current in $steps steps");
                output($steps);
                if (count($ends[$start]) === 10 ) {
                    break 2;
                }
            }
            if ($steps > $maxSteps) {
//            if ($current === 'ZZZ' || $steps > 1000000) {
//                output("Found ZZZ in $steps steps");
                break 2;
            }
        }
    } while ($steps <= $maxSteps);
//    } while ($current !== 'ZZZ');

    output("Start $ctr: Found " . count($ends[$start]) . " ends");
    output("------------------------------------");

    if ($ctr === 1) {
        $first = array_shift($ends);
    } else {
        $first = array_intersect($first, $ends[$start]);
        if (empty($first)) {
//            die("No common ends" . PHP_EOL);
        }
    }
}

print_r($first);


