<?php

class Disc
{

    public int $id;
    public int $num;
    public int $start;
    public int $pos;


    public function __construct($id, $num, $start)
    {
        $this->id    = $id;
        $this->num   = $num;
        $this->start = $start;
    }


    public function calcPosition($time)
    {
        $this->pos = ($this->start + $time + $this->id) % $this->num;
        // $this->pos = $this->start;
        // for ($i = 0; $i < ($time + $this->id); $i++) {
        //     $this->rotate();
        // }
    }


    private function rotate()
    {
        $this->pos++;
        if ($this->pos >= $this->num) {
            $this->pos = 0;
        }
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';


// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$discs = [];
$time  = 0;
$done  = FALSE;

foreach ($data->rows() as $row) {
    $discs[] = parseData($row);
}
$discs[] = new Disc(7, 11, 0);

while ( ! $done) {

    foreach ($discs as $disc) {
        $disc->calcPosition($time);
    }

    $wrongs = array_filter($discs, function ($disc) {
        return $disc->pos !== 0;
    });

    if (count($wrongs) > 0) {
        $time++;
    } else {
        $done = TRUE;
    }
}


output("Time:  $time");


function parseData($row)
{
    [, $id, , $num, , , , , , , , $start] = explode(' ', $row);
    $id    = str_replace('#', '', $id);
    $start = str_replace('.', '', $start);

    return new Disc($id, $num, $start);
}
