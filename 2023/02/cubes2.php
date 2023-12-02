<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$power = 0;
$games = [];
$empty = ['red' => 0, 'green' => 0, 'blue' => 0];

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
    $mins  = ['red' => PHP_INT_MIN, 'green' => PHP_INT_MIN, 'blue' => PHP_INT_MIN];

    foreach ($gameDataSets as $gameDataSet) {
        foreach ($gameDataSet as $color => $qty) {
            if ($qty > $mins[$color]) {
                $mins[$color] = $qty;
            }
        }
    }

    $power += array_product($mins);
}

output("Power: $power");
