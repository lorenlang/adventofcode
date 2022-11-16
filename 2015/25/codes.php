<?php

use Utility\FileReader;

// require_once '../../vendor/autoload.php';
require_once '../../functions.php';
// require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));


$code    = 20151125;
$mult    = 252533;
$div     = 33554393;
// $row     = 6;
// $col     = 2;
$row     = 2978;
$col     = 3083;
$currRow = 1;
$currCol = 1;

$holdRow = $currRow;


/**
 * @param     $code
 * @param int $mult
 * @param int $div
 *
 * @return int
 */
function calculate($code, int $mult, int $div): int
{
    return ($code * $mult) % $div;
}

while ($currRow != $row || $currCol != $col) {
    if (--$currRow <= 0) {
        $currRow = ++$holdRow;
        $currCol = 1;
    } else {
        $currCol++;
    }

    $code = calculate($code, $mult, $div);
}

output("Code: $code");





