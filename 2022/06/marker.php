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
    for ($i = 0; $i < strlen($dataRow) - 3; $i++) {
        if (count(array_unique([$dataRow[$i], $dataRow[$i + 1], $dataRow[$i + 2], $dataRow[$i + 3],])) == 4) {
            $marker = $i + 4;
            break;
        }
    }
output("Marker is after: " . $marker);
}

