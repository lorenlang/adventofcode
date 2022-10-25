<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

$numSeconds = 1000;
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
        'move'  => TRUE,
        'total' => 0,
    ];
}

// print_r($reindeers);
// output(print_r($reindeers));


for ($i = 1; $i <= $numSeconds; $i++) {
    foreach ($reindeers as $reindeer) {

    }
}


/*
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
*/


class Reindeer
{

    public $name;
    public $speed;
    public $time;
    public $rest;
    public $distance;
    public $points;
    public $move;


    /**
     * @param $name
     * @param $speed
     * @param $time
     * @param $rest
     */
    public function __construct($name, $speed, $time, $rest)
    {
        $this->name     = $name;
        $this->speed    = $speed;
        $this->time     = $time;
        $this->rest     = $rest;
        $this->distance = 0;
        $this->points   = 0;
        $this->move     = TRUE;
    }


    


}
