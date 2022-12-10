<?php


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));


$x        = 1;
$cycle    = 0;
$modifier = 0;
$pixels = array_fill(0, 240, ' ');

foreach ($data->rows() as $dataRow) {
    output($dataRow);
    $valid = range($x - 1, $x + 1);

    if ($dataRow == 'noop') {
        if (in_array($cycle - (floor($cycle / 40) * 40), $valid)) {
            $pixels[$cycle] = '#';
        }
        $cycle++;
    } else if (substr($dataRow, 0, 4) == 'addx') {
        [, $val] = explode(' ', $dataRow);
        for ($i = 0; $i < 2; $i++) {
            if (in_array($cycle - (floor($cycle / 40) * 40), $valid)) {
                $pixels[$cycle] = '#';
            }
            $cycle++;
        }
        $x += $val;
    } else {
        die("FATAL ERROR: Unrecognized command :: $dataRow");
    }

}

drawScreen($pixels);


function drawScreen($pixels)
{
    output('');
    foreach ($pixels as $index => $pixel) {
        if ($index % 40 == 0) {
            echo PHP_EOL;
        }
        echo $pixel;
    }
    output('');

}
