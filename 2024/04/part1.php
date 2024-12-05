<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

const DIRECTIONS = [
    'N' => [-1, 0],
    'NE' => [-1, 1],
    'E' => [0, 1],
    'SE' => [1, 1],
    'S' => [1, 0],
    'SW' => [1, -1],
    'W' => [0, -1],
    'NW' => [-1, -1],
];
const PATTERN = ['X','M','A','S'];
define('PATTERN_LENGTH', count(PATTERN));
const OFFSET = PATTERN_LENGTH - 1;

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;
$grid = [];
$rowCount = 0;
foreach ($data->rows() as $dataRow) {
    $row = str_split($dataRow);
    $grid[$rowCount++] = $row;
}

foreach ($grid as $row => $cols) {
    foreach ($cols as $col => $value) {
        if ($value === 'X') {
            $total += check($grid, $row, $col);
        }
    }
}

output("Total matches: $total");


function check($grid, $row, $col): int
{
    $matches = 0;

    foreach (DIRECTIONS as $directionCode => $DIRECTION) {
        if(isValid($grid, $row, $col, $DIRECTION )) {
            if(checkMatch($grid, $row, $col, $DIRECTION)) {
                $matches++;
            };
        }
    }

    return $matches;
}


function checkMatch($grid, $row, $col, $DIRECTION): bool
{
    $holdRow = $row;
    $holdCol = $col;

    for ($i = 0; $i < PATTERN_LENGTH; $i++) {
        $row = $holdRow + ($i * $DIRECTION[0]);
        $col = $holdCol + ($i * $DIRECTION[1]);
        if ($grid[$row][$col] !== PATTERN[$i]) {
            return FALSE;
        }
    }
    return TRUE;
}


function isValid($grid, $row, $col, array $DIRECTION): bool
{
    return isset($grid[$row + ($DIRECTION[0] * OFFSET)][$col + ($DIRECTION[1] * OFFSET)]);
}
