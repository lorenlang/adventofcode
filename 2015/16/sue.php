<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$attributes = [
    'children'    => 3,
    'cats'        => 7,
    'samoyeds'    => 2,
    'pomeranians' => 3,
    'akitas'      => 0,
    'vizslas'     => 0,
    'goldfish'    => 5,
    'trees'       => 3,
    'cars'        => 2,
    'perfumes'    => 1,
];

foreach ($data->rows() as $row) {

    [$name, $data] = explode(':', $row, 2);
    [, $num] = explode(' ', $name);
    $things = explode(',', $data);

    $sue[$num] = [];
    foreach ($things as $thing) {
        [$key, $value] = explode(':', $thing);
        $sue[$num][trim($key)] = (int)$value;
    }

}


foreach ($attributes as $attribute => $quantity) {
    $sue = array_filter($sue, function ($aunt) use ($attribute, $quantity) {

        if ( ! array_key_exists($attribute, $aunt)) {
            return TRUE;
        } else {
            if (in_array($attribute, ['cats', 'trees']) && $aunt[$attribute] > $quantity) {
                return TRUE;
            } else if (in_array($attribute, ['pomeranians', 'goldfish']) && $aunt[$attribute] < $quantity) {
                return TRUE;
            } else if($aunt[$attribute] == $quantity){
                return TRUE;
            };
        }

        return FALSE;

        // return ((array_key_exists($attribute,
        //                           $aunt) && $aunt[$attribute] == $quantity) || ! array_key_exists($attribute, $aunt));
    });
}

print_r($sue);
