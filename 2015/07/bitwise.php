<?php

// THIS DIDN'T WORK - DID IT IN EXCEL - SEE THE CSV IN THIS DIRECTORY

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

$signals = [];

foreach ($data->rows() as $row) {
    list($data, $wire) = explode('->');
    $signals[trim($wire)] = makeCircuit(trim($data));

}

print_r($signals);

// foreach ($signals as $wire => $signal) {
//     output ("$wire:  $signal");
// }


function makeCircuit($data)
{
    $ops = ['AND', 'OR', 'NOT', 'LSHIFT', 'RSHIFT',];
    $retArr = ['op' => NULL, 'val1' => NULL, 'val2' => NULL,];
    $parts = explode(' ', $data);
    foreach ($parts as $part) {
        if (in_array($part, $ops)) {
            $retArr['op'] = $part;
        } elseif (is_numeric($part)) {
            if (isset($retArr['val1'])) {
                $retArr['val2'] = $part;
            } else {
                $retArr['val1'] = $part;
            }
        }
    }
}
