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


    public function getRowCoverage($targetRow, $max)
    {
        $coords = [];
        if (($this->getRow() + $this->getDistance() >= $targetRow) && ($this->getRow() - $this->getDistance() <= $targetRow)) {
            $distanceToRow = abs($targetRow - $this->getRow());
            $startCol      = max($this->getCol() - ($this->getDistance() - $distanceToRow), 0);
            $endCol        = min($this->getCol() + ($this->getDistance() - $distanceToRow), $max);
            $coords        = [$startCol, $endCol];

            // if ($this->beacon['y'] == $targetRow) {
            //     $coords = array_diff($coords, [$this->beacon['x']]);
            // }
        }

        return $coords;
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $max  = 20;
$data = new FileReader(currentDir('data.txt'));
$max  = 4000000;

$sensors = [];

$possible = [];

foreach ($data->rows() as $index => $dataRow) {
    $sensors[] = new Sensor($dataRow);
}

foreach (range(0, $max) as $row) {
    if ($row % 1000 == 0) {
      output($row);
    } else if($row % 10 == 0) {
        echo '.';
    }
    $possible = [];
    foreach ($sensors as $sensor) {
        // $possible[] = $sensor->getRowCoverage($row, $max);
        $coords = $sensor->getRowCoverage($row, $max);
        if ($coords) {
            $possible = array_merge(range($coords[0], $coords[1]), $possible);
        }
        // $possible = array_unique($possible);
    }

    $col = array_diff(range(0, $max), $possible);
    if ($col) {
        $col = array_shift($col);
        output('Freq: ' . ($col * 400000 + $row));
        die();
    }

}


// foreach ($possible as $index => $row) {
//     $work = [];
//     if ($row) {
//         foreach ($row as $coords) {
//             if ($coords) {
//                 $work = array_unique(array_merge(range($coords[0], $coords[1]), $work));
//             }
//         }
//     }
//     if (count($work) < $max + 1) {
//         $row  = $index;
//         $hold = $work;
//     }
// }

// $possible = array_filter($possible, function ($foo) use ($max) {
//     return count($foo) !== ($max + 1);
// });

// $row = array_key_first($possible);
// $col = array_diff(range(0, $max), $possible);
// $col = array_shift($col);
//
// output('Freq: ' . ($col * 400000 + $row));
