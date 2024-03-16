<?php
memory_reset_peak_usage();
$start_time = microtime(true);

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

//$distanceCoefficient = 2;        // Part 1
$distanceCoefficient = 1000000;  // Part 2

$galaxies = [];

foreach ($data->rows() as $index => $dataRow) {
    if (! isset($clearColumns)) {
        $clearColumns = range(0, strlen($dataRow) - 1);
    }

    if (str_contains($dataRow, '#')) {
        preg_match_all('/#/', $dataRow, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $match) {
            $galaxies[] = ['row' => $index, 'col' => $match[1]];
            $clearColumns = array_diff($clearColumns, [$match[1]]);
        }
    } else {
        $clearRows[] = $index;
    }
}

$distance = 0;
$galaxyCount = count($galaxies);
for ($i = 0; $i < $galaxyCount; $i++) {
    for ($j = $i + 1; $j < $galaxyCount; $j++) {
        $distance += abs($galaxies[$i]['row'] - $galaxies[$j]['row']) + abs($galaxies[$i]['col'] - $galaxies[$j]['col']);
        $extraRows = array_filter($clearRows, fn($row) => $row > min($galaxies[$i]['row'], $galaxies[$j]['row']) && $row < max($galaxies[$i]['row'], $galaxies[$j]['row']));
        $distance += (count($extraRows) * ($distanceCoefficient - 1));
        $extraColumns = array_filter($clearColumns, fn($col) => $col > min($galaxies[$i]['col'], $galaxies[$j]['col']) && $col < max($galaxies[$i]['col'], $galaxies[$j]['col']));
        $distance += (count($extraColumns) * ($distanceCoefficient -1));
    }
}

echo $distance, "\n";

echo "Execution time: ".round(microtime(true) - $start_time, 4)." seconds\n";
echo "   Peak memory: ".round(memory_get_peak_usage() / (2 ** 20), 4), " MiB\n\n";
