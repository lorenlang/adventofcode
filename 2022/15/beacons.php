<?php


class Sensor
{

    private $position;
    private $beacon;


    public function __construct($init)
    {
        [$sensorString, $beaconString] = explode(': ', $init);
        [, $sensorString] = explode('at ', $sensorString);
        [, $beaconString] = explode('at ', $beaconString);
        foreach (explode(', ', $sensorString) as $coord) {
            [$key, $val] = explode('=', $coord);
            $this->position[$key] = $val;
        }
        foreach (explode(', ', $beaconString) as $coord) {
            [$key, $val] = explode('=', $coord);
            $this->beacon[$key] = $val;
        }

    }


    public function getDistance()
    {
        return abs($this->position['x'] - $this->beacon['x']) + abs($this->position['y'] - $this->beacon['y']);
    }


    private function getRow()
    {
        return $this->position['y'];
    }


    private function getCol()
    {
        return $this->position['x'];
    }


    public function getRowCoverage($targetRow)
    {
        $coords = [];
        if (($this->getRow() + $this->getDistance() >= $targetRow) && ($this->getRow() - $this->getDistance() <= $targetRow)) {
            $distanceToRow = abs($targetRow - $this->getRow());
            $startCol      = $this->getCol() - ($this->getDistance() - $distanceToRow);
            $endCol        = $this->getCol() + ($this->getDistance() - $distanceToRow);
            $coords        = range($startCol, $endCol);

            if ($this->beacon['y'] == $targetRow) {
                $coords = array_diff($coords, [$this->beacon['x']]);
            }
        }


        return $coords;
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $targetRow = 10;
$data = new FileReader(currentDir('data.txt'));
$targetRow = 2000000;


$possible  = [];

foreach ($data->rows() as $index => $dataRow) {

    $sensor   = new Sensor($dataRow);
    $possible = array_unique(array_merge($sensor->getRowCoverage($targetRow), $possible));

}

output (count($possible));
