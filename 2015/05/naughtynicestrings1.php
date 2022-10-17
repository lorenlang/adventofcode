<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$nice = 0;

foreach ($data->rows() as $row) {
    $vowels    = 0;
    $double    = FALSE;
    $forbidden = FALSE;

    $chars = str_split($row);
    foreach ($chars as $index => $char) {
        if (isVowel($char)) {
            $vowels++;
        }

        if ($index > 0) {
            if ($char == $chars[$index - 1]) {
                $double = TRUE;
            }
            if (forbiddenString($chars[$index - 1] . $char)) {
                $forbidden = TRUE;
            }
        }
    }

    if ($vowels > 2 && $double && ! $forbidden) {
        $nice++;
    }

}
output("Nice count: $nice");


function isVowel($char)
{
    return in_array($char, str_split('aeiou'));
}

function forbiddenString($str)
{
    return in_array($str, ['ab', 'cd', 'pq', 'xy',]);
}
