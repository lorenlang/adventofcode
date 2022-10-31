<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));


$replacements = [];
foreach ($data->rows() as $num => $row) {
    if (FALSE === strpos($row, '=>')) {
        // $calibration = explode(' ', trim(preg_replace('/([A-Z][a-z]?+)/', '\1 ', $row)));
        $molecule = $row;
    } else {
        [$to, $fr] = explode(' => ', $row);
        $replacements[$fr] = $to;
    }
}

// $keys = array_keys($replacements);
// uksort($keys, function ($a, $b) {
//     return strlen($b) - strlen($a);
// });



$steps = 0;
while ($molecule != 'e') {

    $keys = array_keys($replacements);
    uksort($keys, function ($a, $b) {
        return strlen($b) - strlen($a);
    });

    $key = array_pop($keys);
    output("Key is:  $key");
    output("Repl is: ". $replacements[$key]);
    while (FALSE !== strpos($molecule, $key)) {
        $molecule = substr_replace($molecule, $replacements[$key], strpos($molecule, $key), strlen($key));
        output($molecule);
        sleep(2);

    }
}



// print_r($keys);
// print_r($replacements);



