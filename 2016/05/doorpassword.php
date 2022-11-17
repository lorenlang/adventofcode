<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

// $door = 'abc';
$door     = 'wtnhxymk';
$password = '________';
// $password = '';
$index = -1;

while (strlen(stripNonAlphaNumeric($password)) < 8) {
    $index++;
    $hash = md5("$door$index");
    if (substr($hash, 0, 5) === "00000") {
        $pos  = substr($hash, 5, 1);
        $char = substr($hash, 6, 1);
        if (in_array($pos, range(0, 7)) && $password[(int)$pos] == '_') {
            $password[(int)$pos] = $char;
            output("Password: |$password|");
        }
    }
}

output('');
output("Password: $password");
