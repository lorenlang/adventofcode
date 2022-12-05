<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$reg      = array_fill_keys(['a', 'b', 'c', 'd'], 0);
$reg['c'] = 1;  // For part 2
$instr    = [];
$done     = FALSE;

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


foreach ($data->rows() as $row) {
    $instr[] = $row;
}


for ($i = 0; $i < count($instr); $i++) {

    [$command, $parms] = explode(' ', $instr[$i], 2);

    switch ($command) {
        case 'cpy':
            [$source, $dest] = explode(' ', $parms);
            $reg[$dest] = (is_numeric($source) ? $source : $reg[$source]);
            break;

        case 'inc':
            $reg[$parms]++;
            break;

        case 'dec':
            $reg[$parms]--;
            break;

        case 'jnz':
            [$comp, $steps] = explode(' ', $parms);
            $comp = is_numeric($comp) ? $comp : $reg[$comp];
            if ($comp !== 0) {
                $i += ($steps - 1);
            }
            break;

    }

}

output("Value:  " . $reg['a']);

