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
    if (!updateIsCorrect($pages, $rules)) {
        $fixed = makeCorrect($pages, $rules);
        $total += findMiddle($fixed);
    }
}


output("Total: $total");


function makeCorrect(array $pages, array $rules): array
{
//    print_r($pages);
//    print_r($rules);

    while (updateIsCorrect($pages, $rules) === FALSE) {
        foreach ($pages as $index => $page) {
            if (array_key_exists($page, $rules) && pageIsCorrect($index, $pages, $rules[$page]) === FALSE) {
//                $pages[$index] = findMiddle($rules[$page]);
//                output("Page: $page, Index: $index, Rules: " . json_encode($rules[$page]));
                $pages = fixPage($index, $pages, $rules[$page]);
            }
        }
//        print_r($pages);
//        die();
    }

    return $pages;
}


function fixPage(int $index, array $pages, array $rules): array
{

//    output("Page: " . $pages[$index] . " Index: $index, Rules: " . json_encode($rules));
    $fixed = [];
    foreach ($rules as $rule) {
        if (in_array($rule, $pages, TRUE) && array_search($rule, $pages, TRUE) < $index) {
//            $fixed[] = $rule;
//        output("Rule: $rule, Index: " . array_search($rule, $pages, TRUE));
            // switch the values of $pages[$index] and $pages[array_search($rule, $pages, TRUE)]
            $temp                                     = $pages[$index];
            $pages[$index]                            = $pages[array_search($rule, $pages, TRUE)];
            $pages[array_search($rule, $pages, TRUE)] = $temp;

        }
    }

    return $pages;
}


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
