<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    $houses = [];
    $x              = 0;
    $y              = 0;
    addPresent($x, $y, $houses);

    foreach (str_split($row) as $dir) {
        switch ($dir) {
            case '^':
                addPresent(++$x, $y, $houses);
                break;

            case 'v':
                addPresent(--$x, $y, $houses);
                break;

            case '<':
                addPresent($x, --$y, $houses);
                break;

            case '>':
                addPresent($x, ++$y, $houses);
                break;
        }

    }
    output('Count is '.count($houses));
}

function addPresent($x, $y, &$houses)
{
    output("Adding present at :: ($x, $y)");
    if (isset($houses["$x $y"])) {
        $houses["$x $y"] += 1;
    } else {
        $houses["$x $y"] = 1;
    }
}
