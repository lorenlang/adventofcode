<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$count = 0;

foreach ($data->rows() as $row) {
    if (preg_match('/\[[a-z]*?([a-z])([a-z])(\2)(\1)[a-z]*?]/', $row, $matches)) {
        if ($matches[1] != $matches[2]) {
            output("$row  ::  No TLS  " . $matches[0]);
            continue;
        }
    }

    if (preg_match('/([a-z])([a-z])(\2)(\1)/', $row, $matches)) {
        if ($matches[1] == $matches[2]) {
            output("$row  ::  No TLS  " . $matches[0]);
            continue;
        }
        output("$row  ::  TLS  " . $matches[0]);
        $count++;
    }


}


output("Count: $count");
