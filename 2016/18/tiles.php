<?php

//class Path
//{
//    private $path;
//    private $position;
//
//    public function __construct($path, $position)
//    {
//        $this->path     = $path;
//        $this->position = $position;
//    }
//
//    public function getPath()
//    {
//        return $this->path;
//    }
//
//    public function getPosition()
//    {
//        return $this->position;
//    }
//
//    public function getLength()
//    {
//        return strlen($this->path);
//    }
//
//}


require_once '../../autoload.php';
require_once '../../functions.php';

//$firstRow = '..^^.';
//$totalRows = 3;
//$firstRow = '.^^.^.^^^^';
//$totalRows = 10;
$firstRow = '^.....^.^^^^^.^..^^.^.......^^..^^^..^^^^..^.^^.^.^....^^...^^.^^.^...^^.^^^^..^^.....^.^...^.^.^^.^';
//$totalRows = 40;
$totalRows = 400000;
$rows = [$firstRow];

for ($i = 1; $i < $totalRows; $i++) {
    $rows[] = getNextRow($rows[$i - 1]);
}

$numberOfSafeTiles = 0;
foreach ($rows as $row) {
    $numberOfSafeTiles += substr_count($row, '.');
}

output("Number of safe tiles: $numberOfSafeTiles");

function getNextRow($row)
{
    $nextRow = '';
    $length = strlen($row);
    for ($i = 0; $i < $length; $i++) {
        $left = $i == 0 ? '.' : $row[$i - 1];
        $center = $row[$i];
        $right = $i == $length - 1 ? '.' : $row[$i + 1];

        if ($left === '^' && $center === '^' && $right === '.') {
            $nextRow .= '^';
        } elseif ($left === '.' && $center === '^' && $right === '^') {
            $nextRow .= '^';
        } elseif ($left === '^' && $center === '.' && $right === '.') {
            $nextRow .= '^';
        } elseif ($left === '.' && $center === '.' && $right === '^') {
            $nextRow .= '^';
        } else {
            $nextRow .= '.';
        }
    }

    return $nextRow;
}
