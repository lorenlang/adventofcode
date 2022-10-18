<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

$signals = [];

foreach ($data->rows() as $row) {

    $signals[] = makeCircuit($row);

}

foreach ($signals as $wire => $signal) {
    output ("$wire:  $signal");
}


function makeCircuit($data)
{
    //
}
