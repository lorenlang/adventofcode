<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data     = new FileReader(currentDir('test.txt'));
// $quantity = 25;
$data = new FileReader(currentDir('data.txt'));
$quantity = 150;

$containers = [];
foreach ($data->rows() as $row) {
    $containers[] = (int)$row;
}


$min = count($containers);
for ($i = 1; $i <= count($containers); $i++) {
    $combinations = new Combinations($containers, $i);

    foreach ($combinations->generator() as $combination) {
        if (array_sum($combination) == $quantity) {
            $min = min($min, count($combination));
        }
    }
}

$count = 0;
$combinations = new Combinations($containers, $min);
foreach ($combinations->generator() as $combination) {
    if (array_sum($combination) == $quantity) {
        print_r($combination);
        $count++;
    }
}


output($min);
output($count);
