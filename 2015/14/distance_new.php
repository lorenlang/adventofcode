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

    $reindeers[] = new Reindeer(trim($name), (int)(trim($speed)), (int)(trim($time)), (int)(trim($rest)));
}


for ($i = 1; $i <= $numSeconds; $i++) {

    foreach ($reindeers as $reindeer) {
        $reindeer->doSecond();
    }
    awardPoint($reindeers);

    $foo = [];
    foreach ($reindeers as $reindeer) {
            $reindeer->status($i);
    }
}

findWinner($reindeers);


/**
 * @param array $reindeers
 */
function awardPoint(array $reindeers): void
{
    foreach ($reindeers as $reindeer) {
        if ($reindeer->distance == max(array_column($reindeers, 'distance'))) {
            $reindeer->awardPoint();
        }
    }
}


/**
 * @param array $reindeers
 *
 * @return false|int[]|string[]
 */
function findWinner(array $reindeers)
{
    $check = array_combine(array_column($reindeers, 'points'), array_keys($reindeers));

    print_r($reindeers[$check[max(array_keys($check))]]);

}




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
        $this->distance += $this->move ? $this->speed : 0;

        if (--$this->countdown === 0) {
            $this->toggle();
        }
    }


    public function toggle()
    {
        $this->move      = ! $this->move;
        $this->countdown = $this->move ? $this->time : $this->rest;
    }


    public function awardPoint()
    {
        $this->points++;
    }


    public function status($time)
    {
        $output = [
            $time,
            $this->name . ':',
            'D: ' . $this->distance,
            'P: ' . $this->points,
            'C: ' . $this->countdown,
            'M: ' . $this->move,
        ];
        output(join('   ', $output));
    }
}
