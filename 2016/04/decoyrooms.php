<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$total = 0;
foreach ($data->rows() as $row) {
    [$name, $sector, $checksum] = getParts($row);
    if (calcChecksum($name) == $checksum) {
        $total += $sector;
        output("$sector :: " . decryptName($name, $sector));
    }
}

output("Total: $total");


function calcChecksum(string $name): string
{
    $counts = array_count_values(str_split(stripNonAlphabetic($name)));
    arsort($counts);
    $counts['flag'] = -1;

    $currQty  = PHP_INT_MAX;
    $checksum = '';
    $work     = [];

    foreach ($counts as $char => $qty) {
        if ($qty != $currQty) {
            asort($work);
            $checksum .= join('', $work);
            $currQty  = $qty;
            $work     = [];
        }
        $work[] = $char;
    }

    return substr($checksum, 0, 5);
}


function getParts(string $room): array
{
    [$room, $checksum] = explode('[', $room, 2);
    $checksum = stripNonAlphabetic($checksum);
    $parts    = explode('-', $room);
    $sector   = array_pop($parts);
    $name     = join('-', $parts);

    return [$name, $sector, $checksum];
}


function decryptName($name, $sector)
{
    $alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',];

    $decrypted = '';
    foreach (str_split($name) as $char) {
        if ($char == '-') {
            $decrypted .= ' ';
            continue;
        } else {
            $index     = array_search($char, $alpha);
            $decrypted .= $alpha[($index + $sector) % count($alpha)];
        }
    }

    return $decrypted;
}
