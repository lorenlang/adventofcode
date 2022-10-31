<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$replacements = [];
foreach ($data->rows() as $num => $row) {
    if (FALSE === strpos($row, '=>')) {
        $calibration = explode(' ', trim(preg_replace('/([A-Z][a-z]?+)/', '\1 ', $row)));
    } else {
        [$fr, $to] = explode(' => ', $row);
        $replacements[$fr][] = $to;
    }
}

$molecules = [];
foreach ($calibration as $index => $element) {
    if (array_key_exists($element, $replacements)) {

        foreach ($replacements[$element] as $replacement) {
            $molecule         = $calibration;
            $molecule[$index] = $replacement;
            $string           = join('', $molecule);
            if ( ! in_array($string, $molecules)) {
                $molecules[] = $string;
            }
        }

    }
}

output(count($molecules));

// output($calibration);
// print_r($molecules);


