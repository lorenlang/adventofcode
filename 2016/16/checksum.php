<?php

require_once '../../autoload.php';
require_once '../../functions.php';

// $size = 20;
// $data = '10000';
// $size = 272;
$size = 35651584;
$data = '10111011111001111';

while (strlen($data) < $size) {
    $data = lengthen($data);
}

$data = substr($data, 0, $size);

output('Checksum: ' . makeChecksum($data));


function makeChecksum($data)
{
    $checksum = '';
    for ($i = 0; $i < strlen($data); $i += 2) {
        $checksum .= ($data[$i] === $data[$i + 1]) ? '1' : '0';
    }

    while (isEven(strlen($checksum))) {
        $checksum = makeChecksum($checksum);
    }

    return $checksum;
}


function lengthen($data)
{
    return $data . '0' . str_replace('|', '0', str_replace('0', '1', str_replace('1', '|', strrev($data))));
}
