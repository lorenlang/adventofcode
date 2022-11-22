<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test2.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    output(parse($row));
}


function getNext(&$array)
{
    $char = array_shift($array);

    if ($char === FALSE) {
        return FALSE;
    } else if ($char == '0') {
        return 'ZERO';
    } else {
        return (string)$char;
    }
}


function parse($input)
{
    if ( ! preg_match('/\(\d+x\d+\)/', $input)) {
        return strlen($input);
    }

    $total  = 0;
    $marker = FALSE;
    $accum    = '';
    $repeater = '';

    $chars = str_split($input);

    while ($char = getNext($chars)) {
        $char = $char == 'ZERO' ? '0' : $char;

        switch ($char) {
            case '(':
                $marker = TRUE;
                break;

            case ')':
                $marker = FALSE;
                [$numChars, $numRepeat] = explode('x', $repeater);
                for ($i = 0; $i < $numChars; $i++) {
                    $accum .= array_shift($chars);
                }

                $total    += parse($accum) * $numRepeat;
                $accum    = '';
                $repeater = '';
                break;

            default:
                if ($marker) {
                    $repeater .= $char;
                } else {
                    $total++;
                }
        }

    }

    return $total;
}
