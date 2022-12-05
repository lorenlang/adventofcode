<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {
    $marker    = FALSE;
    $result    = '';
    $accum     = '';
    $repeater  = '';
    $chars     = str_split($row);

    while ($char = getNext($chars)) {

        $char = $char == 'ZERO' ? '0' : $char;

        switch ($char) {
            case '(':
                output('Open repeater');
                $marker = TRUE;
                break;

            case ')':
                output('Close repeater');
                $marker = FALSE;
                [$numChars, $numRepeat] = explode('x', $repeater);
                for ($i = 0; $i < $numChars; $i++){
                    $accum .= array_shift($chars);
                }
                output("Accum:  $accum");
                for ($i = 0; $i < $numRepeat; $i++){
                    $result .= $accum;
                }
                $accum = '';
                $repeater = '';
                break;

            default:
                if ($marker) {
                    $repeater .= $char;
                } else {
                    $result .= $char;
                }
        }
        output("Repeater:  $repeater");
    }
    output($result);
    output(str_repeat('-', 15));
    output(strlen($result));
}


function getNext(&$array)
{
    $char = array_shift($array);
    output("Character:  $char");

    if ($char === FALSE) {
        return FALSE;
    } else if ($char == '0') {
        return 'ZERO';
    } else {
        return (string)$char;
    }
}
