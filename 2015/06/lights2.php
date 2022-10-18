<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

$lights = [];
initLights($lights);

foreach ($data->rows() as $row) {

    $row = str_replace(['turn on', 'turn off', '  '], ['on', 'off', ' '], $row);
    list($instr, $coord1, $junk, $coord2) = explode(' ', $row);

    doInstr($instr, $coord1, $coord2, $lights);

}

output(array_sum($lights));


function initLights(&$lights)
{
    doInstr('zero', '0,0', '999,999', $lights);
}


function doInstr($instr, $coord1, $coord2, &$lights)
{
    list($x1, $y1) = explode(',', $coord1);
    list($x2, $y2) = explode(',', $coord2);

    for ($i = $x1; $i <= $x2; $i++) {
        for ($j = $y1; $j <= $y2; $j++) {

            switch ($instr) {
                case 'off':
                    $lights["$i,$j"] = max([0, $lights["$i,$j"] - 1]);
                    break;

                case 'on':
                    $lights["$i,$j"] += 1;
                    break;

                case 'toggle':
                    $lights["$i,$j"] += 2;
                    break;

                case 'zero':
                    $lights["$i,$j"] = 0;
                    break;
            }

        }
    }

}
