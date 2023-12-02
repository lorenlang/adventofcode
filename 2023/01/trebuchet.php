<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;

foreach ($data->rows() as $dataRow) {

    $digits = preg_replace("/[^0-9]/", "", $dataRow);
    $total += (int)($digits[0] . $digits[strlen($digits)-1]);

}

echo $total.PHP_EOL;
