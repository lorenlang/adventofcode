<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    $index = 0;

    while ( ! checkHash(md5(trim($row) . trim($index)))) {
        $index++;
    }

    output($index);
    output(trim($row) . trim($index));
    output(md5(trim($row) . trim($index)));

}


function checkHash($hash)
{
    return ! strncmp($hash, '00000', 5);
}
