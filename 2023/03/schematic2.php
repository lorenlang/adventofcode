<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$sum   = 0;
$sum2  = 0;
$rows  = [];
$gears = [];


foreach ($data->rows() as $dataRow) {
    $rows[] = '.' . $dataRow . '.';
}


foreach ($rows as $index => $row) {
    $sum += array_sum(valuesOnly(getPartNumbers($index, $rows)));
}


//var_export($gears);

foreach ($gears as $key => $gear) {
    if (count($gear) === 2) {
        $sum2 += array_product($gear);
        unset($gears[$key]);
    }
}

output("Sum is: $sum");
output("Sum2 is: $sum2");


function getPartNumbers($index, $rows)
{
    $row   = $rows[$index];
    $above = $index > 0 ? $rows[$index - 1] : NULL;
    $below = $index < count($rows) - 1 ? $rows[$index + 1] : NULL;

    $numbers = array_map(function ($row) {
        preg_match_all('!\d+!', $row, $matches, PREG_OFFSET_CAPTURE);
        return $matches[0];
    }, [$row])[0];

    return array_filter($numbers, function ($number) use ($row, $above, $below, $index) {
        return isPartNumber($number[0], $number[1], $row, $above, $below, $index);
    });
}


function isPartNumber($number, $offset, $row, $above, $below, $index)
{
//    output("Index: $index, Number: $number, Offset: $offset");
//    die();
    global $gears;
    $length = strlen($number);

    if ($offset === FALSE || $length === 0) {
        return FALSE;
    }

    if ($row[$offset - 1] !== '.' || $row[$offset + $length] !== '.') {
        if ($row[$offset - 1] === '*') {
            $key = $index . ($offset - 1);
//            output("Gear key: $key  (Index: $index, Offset-1: " . ($offset - 1));
            $gears[$key][] = $number;
        }
        if ($row[$offset + $length] === '*') {
            $key = $index . ($offset + $length);
//            output("Gear key: $key  (Index: $index, Offset+length: " . ($offset + $length));
            $gears[$key][] = $number;
        }

        return TRUE;
    }

    if ($above !== NULL) {
        $aboveString = substr($above, $offset - 1, $length + 2);
        if (!empty(str_replace('.', '', $aboveString))) {
            if (strpos($aboveString, '*') !== FALSE) {
//                output("Checking ". ($offset - 1) ." thru ". ($offset + $length));
                for ($i = $offset - 1; $i <= $offset + $length; $i++) {
//                    output("Above: $above, I: $i");
                    if ($above[$i] === '*') {
                        $key = ($index - 1) . $i;
//                        output("Gear key: $key  (Index-1: " . ($index - 1) . ", I: $i");
                        $gears[$key][] = $number;
                    }
                }
//                $key           = ($index - 1) . ($offset - 1);
//                $gears[$key][] = $number;
            }

            return TRUE;
        }
    }

    if ($below !== NULL) {
        $belowString = substr($below, $offset - 1, $length + 2);
        if (!empty(str_replace('.', '', $belowString))) {
            if (strpos($belowString, '*') !== FALSE) {
//                output("Checking ". ($offset - 1) ." thru ". ($offset + $length));
                for ($i = $offset - 1; $i <= $offset + $length; $i++) {
//                    output("Below: $below, I: $i");
                    if ($below[$i] === '*') {
                        $key = ($index + 1) . $i;
//                        output("Gear key: $key  (Index+1: " . ($index + 1) . ", I: $i");
                        $gears[$key][] = $number;
                    }
                }
//                $key           = ($index + 1) . ($offset - 1);
//                $gears[$key][] = $number;
            }
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
