<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));
$numPresents = 33100000;
// $numPresents = 500000;

$house = 0;
$count = 0;
$max   = 0;
// $active   = [];
// $inactive = [];

while ($count < $numPresents) {
    $count = 0;
    $house++;
    for ($elf = $house; $elf > 0; $elf--) {
        // if ( ! in_array($elf, $inactive)) {
        // if ($house <= 50 * $elf) {
        if ($house <= 50 * $elf) {
            if ($house % $elf == 0) {
                $count += $elf * 11;
                // $active[$elf] = array_key_exists($elf, $active) ? $active[$elf] + 1 : 1;
                // if ($active[$elf] >= 50) {
                // $inactive[] = $elf;
                // unset($active[$elf]);
                // }
            }
        }
    }

    // print_r($active);
    // print_r($inactive);

    if ($count > $max) {
        $max = $count;
        output("House: $house    Count: $count");
    }
}

output("House: $house    Count: $count");
