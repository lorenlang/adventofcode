<?php

require_once '../../autoload.php';
require_once '../../functions.php';

// define('SALT', 'abc');
define('SALT', 'qzyelonm');
$index = 0;
$keys  = [];
// $hashes = [];


while (count($keys) < 64) {

    if ($char = hasTriple($index)) {

        for ($i = 1; $i <= 1000; $i++) {

            if (hasQuintuple($index + $i, $char)) {
                $keys[] = $index;
                output("$index - FOUND : #" . count($keys) . ' at ' . ($index + $i));
                break;
            }

        }

    }

    $index++;
}
sort($keys);
output($keys[63]);

// output(count($keys) . '   '. $keys[]);

// $verified = getVerified($keys);
// while(count($verified) > 64) {
//     array_pop($verified);
// }
// output(array_key_last($verified));
// print_r(array_pop($verified));


function hasTriple(int $index)
{
    return preg_match('/(.)\1\1/', getHash($index), $matches) ? $matches[1] : FALSE;
}


function hasQuintuple(int $index, string $char)
{
    return preg_match("/$char{5}/", getHash($index));
}


function getHash($index)
{
    $hash = md5(SALT . $index);
    for ($i = 0; $i < 2016; $i++) {
        $hash = md5($hash);
    }

    return $hash;
}
