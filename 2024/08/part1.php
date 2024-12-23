<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$grid     = [];
$rowCount = 0;
foreach ($data->rows() as $dataRow) {
    $row               = str_split($dataRow);
    $grid[$rowCount++] = $row;
}

$minX     = 0;
$maxX     = count($grid[0]) - 1;
$minY     = 0;
$maxY     = count($grid) - 1;
$antennas = [];

foreach ($grid as $row => $cols) {
    foreach ($cols as $col => $value) {
        if ($value !== '.') {
            $antennas[$value][] = [$row, $col];
        }
    }
}

$antinodes = [];
foreach ($antennas as $antenna => $positions) {
    for ($i = 0, $iMax = count($positions); $i < $iMax; $i++) {
        for ($j = 0, $jMax = count($positions); $j < $jMax; $j++) {
            if ($i === $j) {
                continue;
            }

            $xOffset = $positions[$i][1] - $positions[$j][1];
            $yOffset = $positions[$i][0] - $positions[$j][0];
            $xPossible = $positions[$i][0] + $yOffset;
            $yPossible = $positions[$i][1] + $xOffset;
             if ($xPossible < $minX || $xPossible > $maxX || $yPossible < $minY || $yPossible > $maxY) {
                    continue;
             } else {
                 $antinodes[] = [$xPossible, $yPossible];
             }
        }
    }
}

output("Total: " . count(array_unique($antinodes, SORT_REGULAR)));
