<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test2.txt'));
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


            $xOffset = $positions[$i][0] - $positions[$j][0];
            $yOffset = $positions[$i][1] - $positions[$j][1];
//            output("Antenna: $antenna, xOffset: $xOffset, yOffset: $yOffset");
//            output("Position 1: {$positions[$i][0]}, {$positions[$i][1]}");
//            output("Position 2: {$positions[$j][0]}, {$positions[$j][1]}");

            $xCurrent = $positions[$i][0];
            $yCurrent = $positions[$i][1];
            $antinodes[] = [$xCurrent, $yCurrent];
            $flag     = FALSE;

            while (!$flag) {
                $xPossible = $xCurrent + $xOffset;
                $yPossible = $yCurrent + $yOffset;
//                output("Possible: $xPossible, $yPossible");
                if ($xPossible < $minX || $xPossible > $maxX || $yPossible < $minY || $yPossible > $maxY) {
//                    output("Out of bounds");
//                    dashline();
                    $flag = TRUE;
                    continue;
                } else {
//                    output("In bounds");
                    $antinodes[] = [$xPossible, $yPossible];
                    $xCurrent    = $xPossible;
                    $yCurrent    = $yPossible;
//                    dashline();
                }
            }

        }
    }
}

output("Total: " . count(array_unique($antinodes, SORT_REGULAR)));
