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


    $reindeers[] = new Reindeer(trim($name), (int)(trim($speed)), (int)(trim($time)), (int)(trim($rest)));

    // $reindeers[trim($name)] = [
    //     'speed' => (int)(trim($speed)),
    //     'time'  => (int)(trim($time)),
    //     'rest'  => (int)(trim($rest)),
    //     'move'  => TRUE,
    //     'total' => 0,
    // ];
}

// print_r($reindeers);
// var_dump($reindeers);
// output(print_r($reindeers));


for ($i = 1; $i <= $numSeconds; $i++) {
    foreach ($reindeers as $reindeer) {
        $reindeer->doSecond();
        // to preserve keys
    }
    $check = array_combine(array_column($reindeers, 'distance'), array_keys($reindeers));
    // output(max(array_keys($check)));
    // print_r($check);
    $reindeers[$check[max(array_keys($check))]]->awardPoint();
}

print_r($reindeers);


class Reindeer
{

    public $name;
    public $speed;
    public $time;
    public $rest;
    public $distance;
    public $points;
    public $move;
    public $countdown;


    /**
     * @param $name
     * @param $speed
     * @param $time
     * @param $rest
     */
    public function __construct($name, $speed, $time, $rest)
    {
        $this->name      = $name;
        $this->speed     = $speed;
        $this->time      = $time;
        $this->rest      = $rest;
        $this->distance  = 0;
        $this->points    = 0;
        $this->countdown = $this->time;
        $this->move      = TRUE;
    }


    public function doSecond()
    {
        // if ($this->move) {
        //     $this->distance += $this->speed;
        // }
        if ($this->countdown-- === 0) {
            $this->toggle();
        }

        $this->distance += $this->move ? $this->speed : 0;
    }


    public function toggle()
    {
        $this->move      = ! $this->move;
        $this->countdown = $this->move ? $this->speed : $this->rest;
    }


    public function awardPoint()
    {
        $this->points++;
    }

}
