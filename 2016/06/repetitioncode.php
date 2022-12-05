<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$accum = [];
foreach ($data->rows() as $row) {
    $chars = str_split($row);

    foreach ($chars as $index => $char) {
        $accum[$index][] = $char;
    }
}

$message1 = '';
$message2 = '';
foreach ($accum as $pos => $chars) {
    $chars = array_count_values($chars);
    arsort($chars);
    $message1 .= array_key_first($chars);
    $message2 .= array_key_last($chars);

}

output("Message: $message1  $message2");
