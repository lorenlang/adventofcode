<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$nice = 0;

foreach ($data->rows() as $row) {
    $repeated = FALSE;
    $sandwich = FALSE;

    $row = trim($row);
    $chars = str_split($row);
    foreach ($chars as $index => $char) {

        if ($index > 0) {
            if (substr_count($row, $chars[$index - 1] . $char) > 1) {
                $repeated = TRUE;
            }
        }

        if ($index > 1) {
            if ($char == $chars[$index - 2]) {
                $sandwich = TRUE;
            }
        }
    }

    if ($repeated && $sandwich) {
        $nice++;
    }

}
output("Nice count: $nice");
