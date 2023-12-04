<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$cards  = [];
//$points = [];

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
        'qty'  => 1,
        'win'  => $win,
        'have' => $have,
    ];
}

foreach ($cards as $cardNumber => $card) {

//    output("Card number: " . $cardNumber);
    $matches = count(array_intersect($card['win'], $card['have']));
//    output("Matches: " . $matches);
    if ($matches > 0) {
        for ($i = 1; $i <= $matches; $i++) {
            $cards[$cardNumber + $i]['qty'] += $cards[$cardNumber]['qty'];
//            output('Adding '. $cards[$cardNumber]['qty'] .' to card ' . ($cardNumber + $i). ' making it '. $cards[$cardNumber + $i]['qty']);
        }

    }
//    output('-------------------');
}

output("Sum is: " . array_sum(array_column($cards, 'qty')));
