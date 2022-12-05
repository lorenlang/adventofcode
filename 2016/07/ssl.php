<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$count = 0;

foreach ($data->rows() as $row) {
    output($row);

    $possible = [];
    $bracket  = FALSE;
    $found = FALSE;

    $chars = str_split($row);

    for ($i = 0; $i < count($chars) - 2; $i++) {
        if ($chars[$i] == '[') {
            $bracket = TRUE;
        } else if ($chars[$i] == ']') {
            $bracket = FALSE;
        } else if (($chars[$i] == $chars[$i + 2]) && ($chars[$i] != $chars[$i + 1]) && ( ! isBracket($chars[$i + 1])) && ( ! isBracket($chars[$i + 2])) && ( ! $bracket)) {
            $possible[] = $chars[$i] . $chars[$i + 1] . $chars[$i + 2];
        }
    }

    foreach ($possible as $item) {
        $chars = str_split($item);
        $test  = $chars[1] . $chars[0] . $chars[1];
        if (preg_match('/\[[a-z]*?' . $test . '[a-z]*?]/', $row, $matches) && (! $found)) {
            output("FOUND:  $item   " . $matches[0]);
            $found = TRUE;
            $count++;
        }
    }


    output(PHP_EOL . str_repeat('-', 40) . PHP_EOL);
}


output("Count: $count");


function isBracket($char)
{
    return in_array($char, ['[', ']',]);
}
