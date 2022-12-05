<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$instructions = [];
foreach ($data->rows() as $num => $row) {
    $instructions[$num] = $row;
}

// print_r($instructions);


$ptr = 0;
$a   = 1;
$b   = 0;

while (isset($instructions[$ptr])) {
    [$operator, $operand] = explode(' ', $instructions[$ptr], 2);

    switch ($operator) {

        case 'hlf':
            // r sets register r to half its current value, then continues with the next instruction
            ${$operand} = ${$operand} / 2;
            $ptr++;
            break;

        case 'tpl':
            // r sets register r to triple its current value, then continues with the next instruction
            ${$operand} = ${$operand} * 3;
            $ptr++;
            break;

        case 'inc':
            // r increments register r, adding 1 to it, then continues with the next instruction
            ${$operand} = ${$operand} + 1;
            $ptr++;
            break;

        case 'jmp':
            // offset is a jump; it continues with the instruction offset away relative to itself
            $ptr += $operand;
            break;

        case 'jie':
            // r, offset is like jmp, but only jumps if register r is even ("jump if even")
            [$register, $offset] = explode(', ', $operand);
            $ptr += ${$register} % 2 == 0 ? $offset : 1;
            break;

        case 'jio':
            // r, offset is like jmp, but only jumps if register r is 1 ("jump if one", not odd)
            [$register, $offset] = explode(', ', $operand);
            $ptr += ${$register} == 1 ? $offset : 1;
            break;

    }

}


output(PHP_EOL . "A: $a    B: $b");
