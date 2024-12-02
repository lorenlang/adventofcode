<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
 $data = new FileReader(currentDir('data.txt'));

$total = 0;
foreach ($data->rows() as $dataRow) {
    [$one[], $two[]] = preg_split('/\W+/', trim($dataRow));
}

sort($one);
sort($two);
$iMax = count($one);
for ($i = 0; $i < $iMax; $i++) {
    output($one[$i] . '  ::  ' . $two[$i]);
    $total += max($one[$i], $two[$i]) - min($one[$i], $two[$i]);
}

output($total);
