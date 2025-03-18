<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test0.txt'));
//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

const NUM_BLINKS = 25;

foreach ($data->rows() as $dataRow) {
    $tempStones = explode(' ', $dataRow);
}

$stones = new SplDoublyLinkedList();

foreach ($tempStones as $stone) {
    $stones->push($stone);
}


/**
 * @param SplDoublyLinkedList $stones
 * @return void
 */
function displayList(SplDoublyLinkedList $stones): void
{

    for ($stones->rewind(); $stones->valid(); $stones->next()) {
        echo $stones->current() . ' ';
    }
    echo PHP_EOL;
}


/**
 * @param SplDoublyLinkedList $stones
 * @return SplDoublyLinkedList
 */
function processList(SplDoublyLinkedList $stones): SplDoublyLinkedList
{
    $newStones = new SplDoublyLinkedList();

    for ($stones->rewind(); $stones->valid(); $stones->next()) {
        if ($stones->current() === '0') {
            $newStones->push('1');
        } else if (isEven(strlen((string)$stones->current()))) {
            // divide the string into two equal parts
            $half       = strlen((string)$stones->current()) / 2;
            $firstHalf  = (int)substr((string)$stones->current(), 0, $half);
            $secondHalf = (int)substr((string)$stones->current(), $half);
            $newStones->push((string)$firstHalf);
            $newStones->push((string)$secondHalf);
        } else {
            $newStones->push($stones->current() * 2024);
        }
    }

    return $newStones;
}


for ($i = 0; $i < NUM_BLINKS; $i++) {
    $stones = processList($stones);
}

output('Stones: ' . $stones->count());
