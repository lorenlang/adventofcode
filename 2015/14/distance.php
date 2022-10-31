<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$numSeconds = 2503;
$reindeers  = [];

foreach ($data->rows() as $row) {
    $srch = ['can fly', 'km/s for', 'seconds, but then must rest for', 'seconds.', '  ',];
    $repl = ['', '', '', '', ' ',];
    $row  = str_replace($srch, $repl, $row);
    [$name, $speed, $time, $rest] = explode(' ', $row);
    $reindeers[trim($name)] = [
        'speed' => (int)(trim($speed)),
        'time'  => (int)(trim($time)),
        'rest'  => (int)(trim($rest)),
        'total' => (int)(trim($time)) + (int)(trim($rest)),
    ];
}

// output(print_r($reindeers));

$best = 0;

foreach ($reindeers as $name => $reindeer) {

    $full   = $numSeconds / ($reindeer['time'] + $reindeer['rest']);
    $dist   = floor($full) * ($reindeer['speed'] * $reindeer['time']);
    $remain = $numSeconds - (floor($full) * ($reindeer['time'] + $reindeer['rest']));
    if ($remain >= $reindeer['time']) {
        $added = ($reindeer['speed'] * $reindeer['time']);
    } else {
        $added = ($reindeer['speed'] * $remain);
    }
    $total = $dist + $added;

    output("$name -> $total");

    $best = max($total, $best);
}

output("Best: $best");


output (max(array_map(function ($deer) use ($numSeconds) {
    return $deer['speed'] * (floor($numSeconds / $deer['total']) * $deer['time'] + min($numSeconds % $deer['total'], $deer['time']));
}, $reindeers)));
