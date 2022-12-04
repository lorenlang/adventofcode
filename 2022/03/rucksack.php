<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$priorities = array_combine(array_merge(range('a', 'z'), range('A', 'Z')), range(1, 52));

$total = 0;
$counter = 0;
$groups = [];

foreach ($data->rows() as $dataRow) {

    $groups[floor($counter++ / 3)][] = $dataRow;

    $common = array_unique(array_intersect(str_split(substr($dataRow, 0, strlen($dataRow) / 2)), str_split(str_replace(substr($dataRow, 0, strlen($dataRow) / 2), '', $dataRow))));
    $total  += $priorities[array_pop($common)];
}

output("Part 1 total: " . $total);


$total = 0;
foreach ($groups as $group) {

    $common = array_unique(array_intersect(str_split($group[0]),str_split($group[1]),str_split($group[2])));
    $total  += $priorities[array_pop($common)];

}
output("Part 2 total: " . $total);
