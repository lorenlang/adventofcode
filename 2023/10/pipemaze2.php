<?php

use LucidFrame\Console\ConsoleTable;
use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../vendor/phplucidframe/console-table/src/LucidFrame/Console/ConsoleTable.php';

$table = new ConsoleTable();
$table->setHeaders(['Row', 'Col', 'Symbol', 'Parity', 'Count',])->setPadding(2);

//$data = new FileReader(currentDir('test.txt'));
//$data = new FileReader(currentDir('test2.txt'));
//$data = new FileReader(currentDir('test3.txt'));
//$data = new FileReader(currentDir('test4.txt'));
$data = new FileReader(currentDir('data.txt'));

$map  = [];
$loop = [];

foreach ($data->rows() as $dataRow) {
    if (strpos($dataRow, 'S') !== FALSE) {
        $start  = ['row' => count($map), 'col' => strpos($dataRow, 'S'),];
        $loop[] = $start;
    }
    $map[] = str_split($dataRow);
}

[$connected, $dirs] = findConnectingCoords($map, $start);
$startSymbol = getSymbol($dirs);
$next        = array_shift($connected);
$prev        = $start;


while ($next !== $start) {
    $loop[] = $next;
    $hold   = $next;
    $next   = getNext($next, $prev, $map);
    $prev   = $hold;
}

$map[$start['row']][$start['col']] = $startSymbol;

foreach ($map as $row => $mapRow) {
    foreach ($mapRow as $col => $symbol) {
        if (!in_array(['row' => $row, 'col' => $col], $loop, TRUE)) {
            $map[$row][$col] = ' ';
        }
    }
}

$count = 0;
foreach ($map as $row => $mapRow) {
    $parity = 0;
    foreach ($mapRow as $col => $symbol) {
        if ($symbol === ' ' && $parity % 2 !== 0) {
            $count++;
        } else if (str_contains('|LJ', $symbol)) {
            $parity++;
        }
        $table->addRow()->addColumn($row)->addColumn($col)->addColumn($symbol)->addColumn($parity)->addColumn($count);
    }
}

$table->display();

output("Inside the loop: $count");

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
    $dirs   = [];

    if ($symbol !== 'S') {
        foreach ($possibles as $possible) {
            if (isset($map[$directions[$possible]['row']][$directions[$possible]['col']]) && in_array($map[$directions[$possible]['row']][$directions[$possible]['col']], $directions[$possible]['symbols'])) {
                $coords[] = ['row' => $directions[$possible]['row'], 'col' => $directions[$possible]['col']];
                $dirs[]   = $possible;
            }
        }
        return $coords;
    }


    $row = $coord['row'];
    $col = $coord['col'];


    foreach ($directions as $direction) {
        if (isset($map[$direction['row']][$direction['col']]) && in_array($map[$direction['row']][$direction['col']], $direction['symbols'])) {
            $coords[] = ['row' => $direction['row'], 'col' => $direction['col']];
            $dirs[]   = array_search($direction, $directions);
        }
    }

    return [$coords, $dirs];
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

function getSymbol($dirs)
{
    asort($dirs);
    return match (array_values($dirs)) {
        ['north', 'south'] => $symbol = '|',
        ['east', 'west'] => $symbol = '-',
        ['south', 'west'] => $symbol = '7',
        ['north', 'west'] => $symbol = 'J',
        ['east', 'north'] => $symbol = 'L',
        ['east', 'south'] => $symbol = 'F',
    };
}
