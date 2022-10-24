<?php

use Utility\FileReader;
use Utility\PermutationsGenerator;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';
require_once '../../utility/PermutationsGenerator.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


foreach ($data->rows() as $row) {
    $hold = $row;
    do {
        $row++;
    } while ( ! checkPassword($row));

    output("$hold -> $row");
}


function getSequence($letter)
{
    $letter2 = $letter;
    $letter2 = ++$letter2;
    $letter3 = $letter2;
    $letter3 = ++$letter3;

    return ($letter2 == 'aa' || $letter3 == 'aa') ? FALSE : $letter . $letter2 . $letter3;
}


function checkPassword($password)
{
    return noForbiddenLetters($password) && hasSequence($password) && hasTwoPairs($password);
}


function noForbiddenLetters($password)
{
    // Passwords may not contain the letters i, o, or l, as these letters can be mistaken for other characters and are therefore confusing.
    foreach (['i', 'o', 'l',] as $forbidden) {
        if (FALSE !== strpos($password, $forbidden)) {
            return FALSE;
        }
    }

    return TRUE;
}


function hasSequence($password)
{
    // Passwords must include one increasing straight of at least three letters, like abc, bcd, cde, and so on, up to xyz . They cannot skip letters; abd doesn't count.
    foreach (array_unique(str_split($password)) as $letter) {
        if (getSequence($letter)) {
            if (FALSE !== strpos($password, getSequence($letter))) {
                return TRUE;
            }
        }
    }

    return FALSE;
}


function hasTwoPairs($password)
{
    // Passwords must contain at least two different, non-overlapping pairs of letters, like aa, bb, or zz.
    $count = 0;
    foreach (array_unique(str_split($password)) as $letter) {
        $count += substr_count($password, $letter . $letter);
    }

    return $count > 1;
}
