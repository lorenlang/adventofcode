<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));


$boss = ['HP' => 12, 'Dam' => 7, 'Arm' => 2,];
// $boss   = ['HP' => 103, 'Dam' => 9, 'Arm' => 2,];
$player = ['HP' => 8, 'Dam' => 5, 'Arm' => 5,];
// $player = ['HP' => 100, 'Dam' => 0, 'Arm' => 0,];

$weapon = NULL;
$armor  = NULL;
$ring1  = NULL;
$ring2  = NULL;

$weapons = [
    8  => ['Dam' => 4, 'Arm' => 0],
    10 => ['Dam' => 5, 'Arm' => 0],
    25 => ['Dam' => 6, 'Arm' => 0],
    40 => ['Dam' => 7, 'Arm' => 0],
    74 => ['Dam' => 8, 'Arm' => 0],
];

$armors = [
    13  => ['Dam' => 0, 'Arm' => 1],
    31  => ['Dam' => 0, 'Arm' => 2],
    53  => ['Dam' => 0, 'Arm' => 3],
    75  => ['Dam' => 0, 'Arm' => 4],
    102 => ['Dam' => 0, 'Arm' => 5],
];

$rings = [
    25  => ['Dam' => 1, 'Arm' => 0],
    50  => ['Dam' => 2, 'Arm' => 0],
    100 => ['Dam' => 3, 'Arm' => 0],
    20  => ['Dam' => 0, 'Arm' => 1],
    40  => ['Dam' => 0, 'Arm' => 2],
    80  => ['Dam' => 0, 'Arm' => 3],
];
