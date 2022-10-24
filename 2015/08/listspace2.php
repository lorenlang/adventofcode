<?php

// THIS DIDN'T WORK - DID IT IN EXCEL - SEE THE CSV IN THIS DIRECTORY

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$codecount   = 0;
$memcount    = 0;
$encodecount = 0;
foreach ($data->rows() as $row) {
    eval('$str = ' . $row . ';');
    $str       = trim($str);
    $codecount += strlen($row);
    $memcount  += strlen($str);
    $encodecount += strlen('"'.addslashes($row).'"');
    // output($row);
    // output(addslashes($row));
}

output(str_repeat('-', 30));
output("CODE: $codecount");
output(" MEM: $memcount");
output('DIFF: ' . ($codecount - $memcount));
output(str_repeat('-', 30));
output("ENCODE: $encodecount");
output("  CODE: $codecount");
output('  DIFF: ' . ($encodecount - $codecount));

