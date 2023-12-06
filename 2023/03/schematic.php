<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$sum  = 0;
$rows = [];


foreach ($data->rows() as $dataRow) {
    $rows[] = '.' . $dataRow . '.';
}


foreach ($rows as $index => $row) {
    $sum += array_sum(valuesOnly(getPartNumbers($index, $rows)));
}

output("Sum is: $sum");


function getPartNumbers($index, $rows)
{
    $row   = $rows[$index];
    $above = $index > 0 ? $rows[$index - 1] : NULL;
    $below = $index < count($rows) - 1 ? $rows[$index + 1] : NULL;

    $numbers = array_map(function ($row) {
        preg_match_all('!\d+!', $row, $matches, PREG_OFFSET_CAPTURE);
        return $matches[0];
    }, [$row])[0];

    return array_filter($numbers, function ($number) use ($row, $above, $below) {
        return isPartNumber($number[0], $number[1], $row, $above, $below);
    });
}


function isPartNumber($number, $offset, $row, $above, $below)
{
    $length  = strlen($number);

    if ($offset === FALSE || $length === 0) {
        return FALSE;
    }

    if ($row[$offset - 1] !== '.' || $row[$offset + $length] !== '.') {
        return TRUE;
    }

    if ($above !== NULL) {
        $aboveString = substr($above, $offset - 1, $length + 2);
        if (!empty(str_replace('.', '', $aboveString))) {
            return TRUE;
        }
    }

    if ($below !== NULL) {
        $belowString = substr($below, $offset - 1, $length + 2);
        if (!empty(str_replace('.', '', $belowString))) {
            return TRUE;
        }
    }

    return FALSE;
}


function valuesOnly($array)
{
    return array_map(function ($item) {
        return $item[0];
    }, $array);
}
