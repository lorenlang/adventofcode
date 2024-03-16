<?php
memory_reset_peak_usage();
$start_time = microtime(true);

//use LucidFrame\Console\ConsoleTable;
use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
//require_once '../../vendor/phplucidframe/console-table/src/LucidFrame/Console/ConsoleTable.php';

//$table = new ConsoleTable();
//$table->setHeaders(['Count', 'Start', 'Next', 'Prev',])->setPadding(2);

//$data = new FileReader(currentDir('test.txt'));
//$data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$map  = [];
//$loop = [];

foreach ($data->rows() as $dataRow) {
    if (strpos($dataRow, 'S') !== FALSE) {
        $start = ['row' => count($map), 'col' => strpos($dataRow, 'S'),];
    }
    $map[] = str_split($dataRow);
}

$connected = findConnectingCoords($map, $start);
$next      = array_shift($connected);
$prev      = $start;
$count     = 1;
//$table->addRow()->addColumn($count)->addColumn(pc($start))->addColumn(pc($next))->addColumn(pc($prev));


while ($next !== $start) {

    $hold = $next;
    $next = getNext($next, $prev, $map);
    $prev = $hold;
    $count++;
//    $table->addRow()->addColumn($count)->addColumn(pc($start))->addColumn(pc($next))->addColumn(pc($prev));
}

//$table->display();

output('Furthest distance: ' . $count / 2 . PHP_EOL);
echo "Execution time: ".round(microtime(true) - $start_time, 4)." seconds\n";
echo "   Peak memory: ".round(memory_get_peak_usage()/pow(2, 20), 4), " MiB\n\n";

function pc(array $coord)
{
    return implode(',', $coord);
}

function getNext($next, $prev, $map)
{
    $exits = getExits($map, $next);
    do {
        $next = array_shift($exits);
    } while ($next === $prev);

    return $next;
}


function findConnectingCoords($map, $coord)
{
    $symbol = $map[$coord['row']][$coord['col']];

    if ($symbol === '|') {
        $possibles = ['north', 'south'];
    } else if ($symbol === '-') {
        $possibles = ['west', 'east'];
    } else if ($symbol === '7') {
        $possibles = ['south', 'west'];
    } else if ($symbol === 'J') {
        $possibles = ['north', 'west'];
    } else if ($symbol === 'L') {
        $possibles = ['north', 'east'];
    } else if ($symbol === 'F') {
        $possibles = ['south', 'east'];
    }

    $directions = [
        'north' => ['row' => $coord['row'] - 1, 'col' => $coord['col'], 'symbols' => ['S', '|', '7', 'F']],
        'south' => ['row' => $coord['row'] + 1, 'col' => $coord['col'], 'symbols' => ['S', '|', 'J', 'L']],
        'west'  => ['row' => $coord['row'], 'col' => $coord['col'] - 1, 'symbols' => ['S', '-', 'L', 'F']],
        'east'  => ['row' => $coord['row'], 'col' => $coord['col'] + 1, 'symbols' => ['S', '-', 'J', '7']],
    ];

    $coords = [];

    if ($symbol !== 'S') {
        foreach ($possibles as $possible) {
            if (isset($map[$directions[$possible]['row']][$directions[$possible]['col']]) && in_array($map[$directions[$possible]['row']][$directions[$possible]['col']], $directions[$possible]['symbols'])) {
                $coords[] = ['row' => $directions[$possible]['row'], 'col' => $directions[$possible]['col']];
            }
        }
        return $coords;
    }


    $row = $coord['row'];
    $col = $coord['col'];


    foreach ($directions as $direction) {
        if (isset($map[$direction['row']][$direction['col']]) && in_array($map[$direction['row']][$direction['col']], $direction['symbols'])) {
            $coords[] = ['row' => $direction['row'], 'col' => $direction['col']];
        }
    }

    return $coords;
}

function getDirection($coord, $dir)
{
    switch ($dir) {
        case 'north':
            $result = ['row' => $coord['row'] - 1, 'col' => $coord['col']];
            break;
        case 'south':
            $result = ['row' => $coord['row'] + 1, 'col' => $coord['col']];
            break;
        case 'west':
            $result = ['row' => $coord['row'], 'col' => $coord['col'] - 1];
            break;
        case 'east':
            $result = ['row' => $coord['row'], 'col' => $coord['col'] + 1];
            break;
    }

    return $result;
}


function getExits($map, $coord)
{
    $wall = $map[$coord['row']][$coord['col']];

    if ($wall === '|') {
        $exits = [getDirection($coord, 'north'), getDirection($coord, 'south')];
    } else if ($wall === '-') {
        $exits = [getDirection($coord, 'west'), getDirection($coord, 'east')];
    } else if ($wall === '7') {
        $exits = [getDirection($coord, 'south'), getDirection($coord, 'west')];
    } else if ($wall === 'J') {
        $exits = [getDirection($coord, 'north'), getDirection($coord, 'west')];
    } else if ($wall === 'L') {
        $exits = [getDirection($coord, 'north'), getDirection($coord, 'east')];
    } else if ($wall === 'F') {
        $exits = [getDirection($coord, 'south'), getDirection($coord, 'east')];
    }

    return $exits;
}
