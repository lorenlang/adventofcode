<?php

require_once '../../autoload.php';
require_once '../../functions.php';

define('STRETCH_HASH', TRUE);
// define('SALT', 'abc');
define('SALT', 'qzyelonm');
$index = -1;
$keys  = [];
$count = 0;


while (count(getVerified($keys)) < 64) {
    // output("Verified count: " . count(getVerified($keys)));

    $index++;
    // output("checking index: $index");

    // output("Unverified count: " . count(getUnverified($keys)));
    foreach (getUnverified($keys) as $idx => $key) {
        $char = hasQuintuple($index);
        // output("Quint check: " . ($char ?: 'False'));
        // output("Char to match: " . $key['char']);
        if ($char && $char == $key['char']) {
            // output("Characters match. Marking as verified");
            $keys[$idx]['verified'] = TRUE;

            if (count(getVerified($keys)) == 64) {
                output("Index: $idx");
                die();
            }
        } else {
            // output("Characters do not match. Decrementing checkCount: " . ($key['checkCount'] - 1));
            $keys[$idx]['checkCount']--;
        }
    }

    $char = hasTriple($index);
    // output("Triple check: " . ($char ?: 'False'));
    if ($char) {
        // output("Adding key:  $char   False   1000");
        $keys[$index] = [
            'char'       => $char,
            'verified'   => FALSE,
            'checkCount' => 1000,
        ];
        $count++;
        // output("$count :: $index");
    }
    // output(str_repeat('-', 40));
    // prompt();
}


// $verified = getVerified($keys);
// while(count($verified) > 64) {
//     array_pop($verified);
// }
// output(array_key_last($verified));
// print_r(array_pop($verified));


function getVerified(array $keys)
{
    return array_filter($keys, function ($key) {
        return $key['verified'];
    });
}


function getUnverified(array $keys)
{
    return array_filter($keys, function ($key) {
        return $key['verified'] === FALSE && $key['checkCount'] > 0;
    });
}


function hasTriple(int $index)
{
    $hash = getHash($index);

    return preg_match('/(.)\1\1/', $hash, $matches) ? $matches[1] : FALSE;
}


function hasQuintuple(int $index)
{
    $hash = getHash($index);

    return preg_match('/(.)\1\1\1\1/', $hash, $matches) ? $matches[1] : FALSE;
}


function getHash($index)
{
    $hash = md5(SALT . $index);
    if (STRETCH_HASH) {

        for ($i = 0; $i < 2016; $i++) {
            $hash = md5($hash);
        }
    }

    return $hash;
}
