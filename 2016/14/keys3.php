<?php

require_once '../../functions.php';

$secret = 'qzyelonm';
// $secret = 'abc';

function getMD5($key, $secret, &$hashTable, $isProb2)
{
    // if($hashTable[$key] == null) {
    if ( ! array_key_exists($key, $hashTable)) {
        if ( ! $isProb2) {
            $hashTable[$key] = md5($secret . $key);
        } else {
            $md5 = md5($secret . $key);
            for ($i = 0; $i < 2016; $i++) {
                $md5 = md5($md5);
            }
            $hashTable[$key] = $md5;
        }
    }

    return $hashTable[$key];
}

function solve($secret, $isProb2)
{
    $currentKey  = 0;
    $correctKeys = [];
    $hashTable   = [];
    while (count($correctKeys) < 64) {
        $currentMD5 = getMD5($currentKey, $secret, $hashTable, $isProb2);

        if (preg_match('/(.)\1{2}/', $currentMD5, $matches)) {
            for ($i = $currentKey + 1; $i < $currentKey + 1001; $i++) {
                $lookMD5 = getMD5($i, $secret, $hashTable, $isProb2);
                if (preg_match('/' . $matches[1] . $matches[1] . $matches[1] . $matches[1] . $matches[1] . '/',
                               $lookMD5, $m)) {
                    $correctKeys[] = $currentKey;
                    break;
                }
            }
        }
        $currentKey++;
    }
    sort($correctKeys);

    return $correctKeys[63];
}

output('Problem 1 index: ' . solve($secret, FALSE));
output('Problem 2 index: ' . solve($secret, TRUE));
