<?php

use Utility\FileReader;
use Utility\PermutationsGenerator;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../utility/PermutationsGenerator.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$guests = [];

foreach ($data->rows() as $row) {
    $srch = ['.', 'gain ', 'lose ',];
    $repl = ['', '', '-',];
    $row  = str_replace($srch, $repl, $row);
    [$key, $data] = explode('would', $row);
    [$value, $index] = explode('happiness units by sitting next to', $data);
    $guests[trim($key)][trim($index)] = (int)trim($value);
    $guests['Me'][trim($key)] = 0;
    $guests[trim($key)]['Me'] = 0;
}

// output(print_r($guests));

$best = 0;
$arrangements = new PermutationsGenerator(array_keys($guests));
foreach ($arrangements as $arrangement) {
    $total = 0;
    foreach ($arrangement as $key => $person) {
        $key2 = key_exists($key + 1, $arrangement) ? $key + 1 : 0;
        $total += $guests[$arrangement[$key]][$arrangement[$key2]];
        $total += $guests[$arrangement[$key2]][$arrangement[$key]];
    }

    $best = max($total, $best);
}

output("Best: $best");
