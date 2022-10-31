<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));
$numPresents = 33100000;

$house = 700000;
$count = 0;
$max = 0;

while ($count < $numPresents) {
    $count = 0;
    $house++;
    for ($elf = $house; $elf > 0; $elf--) {
        if ($house % $elf == 0) {
            $count += $elf * 10;
        }
    }
    if ($count > $max) {
        $max = $count;
        output("House: $house    Count: $count");
    }
}

output("House: $house    Count: $count");
