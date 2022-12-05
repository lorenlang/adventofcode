<?php

use Utility\FileReader;
use Mistralys\SubsetSum\SubsetSum;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$numGroups = 4;

$weights = [];
foreach ($data->rows() as $row) {
    $weights[] = $row;
}
rsort($weights);
$targetWeight = array_sum($weights) / $numGroups;

$sub = SubsetSum::create($targetWeight, $weights);

$numPresents = count($sub->getShortestMatch());

$smallest = array_filter($sub->getMatches(), function ($match) use ($numPresents) {
    return count($match) == $numPresents;
});

$qe = PHP_INT_MAX;

foreach ($smallest as $group) {
    $qe = min($qe, array_product($group));
}


output("QE: $qe");
