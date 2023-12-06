<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$sum = 0;
$games = [];
$empty = ['red' => 0, 'green' => 0, 'blue' => 0];
$max = ['red' => 12, 'green' => 13, 'blue' => 14];

foreach ($data->rows() as $dataRow) {

    [$id, $gameDataSets] = explode(':', $dataRow);
    $id           = str_replace('Game ', '', $id);
    $gameDataSets = explode(';', $gameDataSets);

    foreach ($gameDataSets as $setId => $gameDataSet) {
        $games[$id][$setId] = $empty;

        foreach(explode(', ', $gameDataSet) as $gameData) {
            [$qty, $color] = explode(' ', trim($gameData));
            $games[$id][$setId][$color] = $qty;
        }

    }

}

foreach ($games as $gameId => $gameDataSets) {
    foreach ($gameDataSets as $gameDataSet) {
        foreach ($gameDataSet as $color => $qty) {
            if ($qty > $max[$color]) {
                continue 3;
            }
        }
    }

    $sum += $gameId;
}

output("Sum: $sum");
