<?php

use Utility\FileReader;
use Utility\TimingHelper;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../utility/TimingHelper.php';

//$data = new FileReader(currentDir('test0.txt'));
//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

const NUM_BLINKS = 75;

foreach ($data->rows() as $dataRow) {
    $stones = explode(' ', $dataRow);
}


function processStone($stone, $blinks): int
{
    if ($blinks === 0) {
        return 1;
    }

    static $cache = [];
    if (isset($cache["$stone-$blinks"])) {
        return $cache["$stone-$blinks"];
    }

    if ($stone === '0') {
        $result = processStone(1, $blinks - 1);

    } else if (isEven(strlen($stone))) {
        $half       = strlen($stone) / 2;
        $firstHalf  = substr($stone, 0, $half);
        $secondHalf = (string)((int)substr($stone, $half));
        $result     = processStone($firstHalf, $blinks - 1) + processStone($secondHalf, $blinks - 1);

    } else {
        $result = processStone($stone * 2024, $blinks - 1);

    }

    $cache["$stone-$blinks"] = $result;

    return $result;
}


function processList($stones)
{
    $total = 0;
    foreach ($stones as $stone) {
        $total += processStone($stone, NUM_BLINKS);
    }

    return $total;
}


//$th = new TimingHelper();
//$th->start();
output('Stones: ' . processList($stones));
//output($th->time());
