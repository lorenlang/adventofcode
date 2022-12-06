<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$testMode = FALSE;

if ($testMode) {
    $data = new FileReader(currentDir('test.txt'));
} else {
    $data = new FileReader(currentDir('data.txt'));
}

foreach ($data->rows() as $dataRow) {
$marker = NULL;
    for ($i = 0; $i < strlen($dataRow) - 13; $i++) {
        $chars = [];
        for ($j = 0; $j < 14; $j++) {
            $chars[] = $dataRow[$i + $j];
        }
        $uniq = array_unique($chars);
        if (count($uniq) == 14) {
            $marker = $i + 14;
            break;
        }
    }
    output("Marker is after: " . $marker);
}

