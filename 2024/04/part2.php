<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';


//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total    = 0;
$grid     = [];
$rowCount = 0;
foreach ($data->rows() as $dataRow) {
    $row               = str_split($dataRow);
    $grid[$rowCount++] = $row;
}

foreach ($grid as $row => $cols) {
    foreach ($cols as $col => $value) {
        if ($value === 'A') {
            $total += check($grid, $row, $col);
        }
    }
}

output("Total matches: $total");


function check($grid, $row, $col): int
{
    $matches = 0;

    if (isValid($grid, $row, $col)) {
        if (checkMatch($grid, $row, $col)) {
            $matches++;
        };
    }

    return $matches;
}


function checkMatch($grid, $row, $col): bool
{
    return (
        (($grid[$row + -1][$col + -1] === 'M' && $grid[$row + 1][$col + 1] === 'S') ||
        ($grid[$row + -1][$col + -1] === 'S' && $grid[$row + 1][$col + 1] === 'M')) &&
        (($grid[$row + 1][$col + -1] === 'M' && $grid[$row + -1][$col + 1] === 'S') ||
        ($grid[$row + 1][$col + -1] === 'S' && $grid[$row + -1][$col + 1] === 'M'))
    );
}


function isValid($grid, $row, $col): bool
{
    return isset($grid[$row + -1][$col + -1], $grid[$row + -1][$col + 1], $grid[$row + 1][$col + -1], $grid[$row + 1][$col + 1]);
}
