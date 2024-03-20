<?php
memory_reset_peak_usage();
$start_time = microtime(TRUE);

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$data = new FileReader(currentDir('test.txt'));
//$data = new FileReader(currentDir('data.txt'));

$outputFile = 'output.txt';
if ($outputFile &&  file_exists($outputFile)) {
    unlink($outputFile);
}

$total = 0;
dashline(15, $outputFile);

foreach ($data->rows() as $index => $dataRow) {
//    $FH = fopen('patterns.txt', 'w');
    [$dataRow, $groups] = explode(' ', $dataRow);
    $dataRow = implode('?', [$dataRow, $dataRow, $dataRow, $dataRow, $dataRow,]);
    $groups = implode(',', [$groups, $groups, $groups, $groups, $groups,]);
    $groups = explode(',', $groups);

    $maxGroup = str_repeat('#', max($groups));
    $overGroup = str_repeat('#', max($groups) + 1);

    $regex    = getRegex($groups);
    $subTotal = tryPatterns($dataRow, $regex, $maxGroup, $overGroup);
    $total += $subTotal;

//    writePatterns($dataRow, $maxGroup, $overGroup, $FH);
//    fclose($FH);

//    $subTotal = 0;
//    $patterns = flatten(getPatterns($dataRow));
//    $patterns = new FileReader(currentDir('patterns.txt'));
//    foreach ($patterns as $pattern) {
//    foreach ($patterns->rows() as $pattern) {
//        if (preg_match($regex, $pattern)) {
//            $subTotal++;
//            $total++;
//        }
//    }

    output("Subtotal: $subTotal", $outputFile);
    dashline(15, $outputFile);
}

output("Total: $total");

output ("Execution time: ".round(microtime(true) - $start_time, 4)." seconds");
output ("   Peak memory: ".round(memory_get_peak_usage() / (2 ** 20), 4) . " MiB");


/**
 * @param string $row
 * @param string $maxGroup
 * @param string $overGroup
 *
 * @return int
 */
function tryPatterns(string $row, string $regex, string $maxGroup, string $overGroup): int
{
    $count = 0;
    $pos    = strpos($row, '?');
    if ($pos !== FALSE) {
        $row1       = $row;
        $row2       = $row;
        $row1[$pos] = '.';
        $row2[$pos] = '#';
        $count += tryPatterns($row1, $regex, $maxGroup, $overGroup);
        $count += tryPatterns($row2, $regex, $maxGroup, $overGroup);
    } else {
        if (str_contains($row, $maxGroup) && !str_contains($row, $overGroup)) {
            if (preg_match($regex, $row)) {
                $count++;
            }
        }
    }
    return $count;
}


/**
 * @param string $row
 * @param string $maxGroup
 * @param string $overGroup
 * @param resource $FH
 */
//function writePatterns(string $row, string $maxGroup, string $overGroup, &$FH): void
//{
//    $pos    = strpos($row, '?');
//    if ($pos !== FALSE) {
//        $row1       = $row;
//        $row2       = $row;
//        $row1[$pos] = '.';
//        $row2[$pos] = '#';
//        writePatterns($row1, $maxGroup, $overGroup, $FH);
//        writePatterns($row2, $maxGroup, $overGroup, $FH);
//    } else {
//        if (str_contains($row, $maxGroup) && !str_contains($row, $overGroup)) {
//            fwrite($FH, $row . PHP_EOL);
//        }
//    }
//}


/**
 * @param string $row
 * @return array
 */
//function getPatterns(string $row): array
//{
//    $return = [];
//    $pos    = strpos($row, '?');
//    if ($pos !== FALSE) {
//        $row1       = $row;
//        $row2       = $row;
//        $row1[$pos] = '.';
//        $row2[$pos] = '#';
//        $return[]   = getPatterns($row1);
//        $return[]   = getPatterns($row2);
//    } else {
//        $return[] = $row;
//    }
//    return $return;
//}


/**
 * @param array $groups
 * @return string
 */
function getRegex(array $groups): string
{
    $regex       = '/^\.*';
    $regexGroups = [];
    foreach ($groups as $group) {
        $regexGroups[] = str_repeat('#', $group);
    }
    $regex .= implode('\.+', $regexGroups);
    $regex .= '\.*$/';
    return $regex;
}


