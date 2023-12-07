<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$typeGroups = [];
$rankings   = [];
$points     = [];

foreach ($data->rows() as $dataRow) {
    [$hand, $bid] = explode(' ', $dataRow);
    $hand                = str_replace(['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'], ['A', 'B', 'C', 'X', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',], $hand);
    $type                = findType($hand);
    $typeGroups[$type][] = ['cards' => $hand, 'bid' => $bid];
}

ksort($typeGroups);

foreach ($typeGroups as $type => $typeGroup) {

    if (count($typeGroup) === 1) {
        $rankings[] = $typeGroup[0]['bid'];
        continue;
    }

    $sorted = array_column($typeGroup, 'cards');
    arsort($sorted);

    foreach (array_keys($sorted) as $key) {
        $rankings[] = $typeGroup[$key]['bid'];
    }

}

foreach ($rankings as $key => $ranking) {
    $points[] = $ranking * ($key + 1);
}

output("Total is: " . array_sum($points));


function findType($hand)
{
    $types = ['5' => 7, '41' => 6, '32' => 5, '311' => 4, '221' => 3, '2111' => 2, '11111' => 1,];

    $cardCount = array_count_values(str_split($hand));
    arsort($cardCount);

    if (array_key_exists('X', $cardCount) && $hand !== 'XXXXX') {
        $jokers = $cardCount['X'];
        unset($cardCount['X']);
        $cardCount[array_key_first($cardCount)] += $jokers;
    }

    return $types[implode('', $cardCount)] ?? 0;
}
