<?php

// THIS DIDN'T WORK - DID IT IN EXCEL - SEE THE CSV IN THIS DIRECTORY

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$hexdigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f',];
$codecount = 0;
$memcount  = 0;
foreach ($data->rows() as $row) {
    $hold      = $row;
    $codecount += strlen($row);
    $temp      = 0;

    if (substr($row, 0, 1) == '"' && substr($row, -1) == '"') {
        output($row);
        output('Strip wrapping quotation marks  (2)');
        $temp += 2;
        $row  = substr($row, 1, strlen($row));
        $row  = substr($row, 0, strlen($row) - 1);
    }

    foreach ($hexdigits as $digit1) {
        foreach ($hexdigits as $digit2) {
            while (substr_count($row, "\x$digit1$digit2")) {
                output($row);
                output("Replace hex character \x$digit1$digit2" . '  (' . substr_count($row,
                                                                                       "\x$digit1$digit2") * 3 . ')');
                $temp += substr_count($row, "\x$digit1$digit2") * 3;
                $row  = str_replace("\x$digit1$digit2", chr(hexdec("$digit1$digit2")), $row);
            }
        }
    }

    while (substr_count($row, '\"')) {
        output($row);
        output('Replace escaped quotation mark  (' . substr_count($row, '\"') . ')');
        $temp += substr_count($row, '\"');
        $row = str_replace('\"', '"', $row);
    }

    while (substr_count($row, '\\\\')) {
        output($row);
        output('Replace escaped backslash  (' . substr_count($row, '\\\\') . ')');
        $temp += substr_count($row, '\\\\');
        $row = str_replace('\\\\', '\\', $row);
    }

    $memcount += strlen($row);


    // $diff += substr_count($row, '\\\\');
    // $diff += substr_count($row, '\\\"');
    // foreach($hexdigits as $digit1) {
    //     foreach ($hexdigits as $digit2) {
    //         $diff += substr_count($row, "\x$digit1$digit2") * 3;
    //     }
    // }


    // echo "$row     " . strlen($row) . "    $diff" . PHP_EOL;
    // print_r(
    //     [
    //         substr_count($row, '\\'),
    //         substr_count($row, '\"'),
    //         substr_count($row, '\x') * 3,
    //     ]
    // );
    output($row);
    output(strlen($hold) . ' -> ' . strlen($row) . ' = ' . (strlen($hold) - strlen($row)) . "   ($temp)");
    output(str_repeat('-', 30));
}

output(str_repeat('-', 30));
output("CODE: $codecount");
output(" MEM: $memcount");
output('DIFF: ' . ($codecount - $memcount));
// output($row);


foreach (file(h) as $l) {
    preg_match_all('#(\\\.)#', $l, $m);
    $a += 2;
    $b += 4;
    foreach ($m[0] as $r) {
        $a += ($r == '\x') ? 3 : 1;
        $b += ($r == '\x') ? 1 : 2;
    }
}
echo "$a/$b";
