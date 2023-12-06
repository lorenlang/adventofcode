<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$cards  = [];
$points = [];

foreach ($data->rows() as $dataRow) {
    $dataRow = preg_replace('/\s+/', ' ', $dataRow);

    [$cardNumber, $cardData] = explode(':', $dataRow);
    $cardNumber = trim(preg_replace('/[^0-9]/', '', $cardNumber));

    [$win, $have] = explode('|', $cardData);
    $win  = explode(' ', trim($win));
    $have = explode(' ', trim($have));
    sort($win);
    sort($have);
    $cards[$cardNumber] = [
        'win'  => $win,
        'have' => $have,
    ];
}

foreach ($cards as $cardNumber => $card) {

    $matches = count(array_intersect($card['win'], $card['have']));
    if ($matches > 0) {
        $points[$cardNumber] = 2 ** ($matches - 1);
    }
}

output("Sum is: " . array_sum($points));
