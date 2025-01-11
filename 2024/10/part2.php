<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test0.txt'));
//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$grid     = [];
$rowCount = 0;
foreach ($data->rows() as $dataRow) {
    $grid[$rowCount++] = array_map(static fn($value) => (int)$value, str_split($dataRow));
}

const MIN_ROW = 0;
const MIN_COL = 0;
define('MAX_COL', count($grid[0]));
define('MAX_ROW', count($grid));

$nodes = findOrigins($grid);

$apexes= [];
foreach ($nodes as $index => $node) {
    $nodes[$index] = findChildren($node, $grid, $index, $apexes);
}

output('Score: ' . count($apexes));



function findChildren($node, $grid, $origin, &$apexes)
{
    if ($node['value'] === 9) {
        $apexes[] = [$origin, $node];
//        $apexes = array_unique($apexes, SORT_REGULAR);
        return $node;
    }

    $row = $node['row'];
    $col = $node['col'];
    $value = $node['value'];

    $children = [];
    $children[] = findChild($row - 1, $col, $value + 1, $grid);
    $children[] = findChild($row + 1, $col, $value + 1, $grid);
    $children[] = findChild($row, $col - 1, $value + 1, $grid);
    $children[] = findChild($row, $col + 1, $value + 1, $grid);

    $children = array_filter($children, static fn($child) => $child !== NULL);

    if (empty($children)) {
        return $node;
    }

    foreach ($children as $index => $child) {
        $children[$index] = findChildren($child, $grid, $origin,$apexes);
    }
    $node['children'] = $children;

    return $node;
}

function findChild($row, $col, $value, $grid)
{
    if ($row < MIN_ROW || $col < MIN_COL || $row >= MAX_ROW || $col >= MAX_COL) {
        return NULL;
    }

    if ($grid[$row][$col] === $value) {
        return ['row' => $row, 'col' => $col, 'value' => $value];
    }

    return NULL;
}


function findOrigins($grid)
{
    // find all entries = 0 in grid and return array of coordinates
    $origins = [];
    foreach ($grid as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            if ($value === 0) {
                $origins[] = ['row' => $rowIndex, 'col' => $colIndex, 'value' => $value];
            }
        }
    }

    return $origins;
}
