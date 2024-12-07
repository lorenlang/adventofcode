<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total   = 0;
$rules   = [];
$updates = [];

foreach ($data->rows() as $dataRow) {
    if (isRule($dataRow)) {
        [$rule, $value] = explode('|', $dataRow);
        $rules[$rule][] = $value;
    } else {
        $updates[] = $dataRow;
    }
}

foreach ($updates as $update) {
    $pages = explode(',', $update);
    if (updateIsCorrect($pages, $rules)) {
        $total += findMiddle($pages);
    }
}


output("Total: $total");


function updateIsCorrect(array $pages, array $rules): bool
{
    foreach ($pages as $index => $page) {
        if (array_key_exists($page, $rules) && pageIsCorrect($index, $pages, $rules[$page]) === FALSE) {
            return FALSE;
        }
    }
    return TRUE;
}


function pageIsCorrect(int $index, array $pages, array $rules): bool
{
    foreach ($rules as $rule) {
        if (in_array($rule, $pages, TRUE) && array_search($rule, $pages, TRUE) < $index) {
            return FALSE;
        }
    }

    return TRUE;
}


function isRule(string $str): bool
{
    return strpos($str, '|') !== FALSE;
}


function findMiddle(array $arr): int
{
    return $arr[((int)(count($arr) / 2))];
}
