<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    $houses = [
        0 => [
            'curr' => [
                'x' => 0,
                'y' => 0,
            ],
        ],
        1 => [
            'curr' => [
                'x' => 0,
                'y' => 0,
            ],
        ],
    ];

    foreach ([0, 1] as $item) {
        addPresent($houses[$item]['curr']['x'], $houses[$item]['curr']['y'], $houses[$item]);
    }

    foreach (str_split($row) as $index => $dir) {
        $item = $index % 2;
        switch ($dir) {
            case '^':
                addPresent(++$houses[$item]['curr']['x'], $houses[$item]['curr']['y'], $houses[$item]);
                break;

            case 'v':
                addPresent(--$houses[$item]['curr']['x'], $houses[$item]['curr']['y'], $houses[$item]);
                break;

            case '<':
                addPresent($houses[$item]['curr']['x'], --$houses[$item]['curr']['y'], $houses[$item]);
                break;

            case '>':
                addPresent($houses[$item]['curr']['x'], ++$houses[$item]['curr']['y'], $houses[$item]);
                break;
        }

    }


    $final = array_merge($houses[0], $houses[1]);
    unset($final['curr']);

    output('Count is ' . count($final));
}

function addPresent($x, $y, &$houses)
{
    // output("Adding present at :: ($x, $y)");
    if (isset($houses["$x $y"])) {
        $houses["$x $y"] += 1;
    } else {
        $houses["$x $y"] = 1;
    }
}
