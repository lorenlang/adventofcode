<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;
$retry = [];

foreach ($data->rows() as $dataRow) {

    [$value, $inputString] = explode(':', $dataRow);
    $inputs = explode(' ', trim($inputString));

    $numOperators = count($inputs) - 1;
    $max          = (1 << $numOperators);
    $flag = FALSE;

    $operatorArray = [];
    for ($i = 0; $i < $max; $i++) {
        // Use $i
        $operatorArray[] = str_pad(decbin($i), $numOperators, '0', STR_PAD_LEFT);
    }

    foreach ($operatorArray as $operatorString) {
        $operators  = str_split($operatorString);
        $workInputs = $inputs;

        foreach ($operators as $operator) {
            $one    = array_shift($workInputs);
            $two    = array_shift($workInputs);
            $result = $operator == 0 ? $one + $two : $one * $two;

            if (empty($workInputs) && $result == $value) {
                $flag = TRUE;
                break(2);
            }

            array_unshift($workInputs, $result);
        }

    }

    if ($flag) {
        $total += $result;
    }
}


output("Total: " . $total);
