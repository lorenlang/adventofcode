<?php


class Sand
{
    public $grid;
    public $position;
    public $dim;
    public $floor;


    /**
     * @param       $grid
     * @param array $position
     */
    public function __construct($position, $grid, $dim, $floor)
    {
        $this->position = $position;
        $this->grid     = $grid;
        $this->dim      = $dim;
        $this->floor    = $floor;
    }


    public function fall()
    {
        while ($this->canMove()) {
            if ($this->canMoveDown()) {
                $this->moveDown();
            } else if ($this->canMoveLeft()) {
                $this->moveLeft();
            } else if ($this->canMoveRight()) {
                $this->moveRight();
            }
        }

        return $this->position;
    }


    private function canMove(): bool
    {
        return $this->canMoveDown() || $this->canMoveLeft() || $this->canMoveRight();
    }


    private function canMoveDown(): bool
    {
        return $this->isOpen($this->position[0], $this->position[1] + 1);
        // return ( ! $this->isOffGrid()) && $this->isOpen($this->position[0], $this->position[1] + 1);
    }


    private function canMoveLeft(): bool
    {
        return $this->isOpen($this->position[0] - 1, $this->position[1] + 1);
        // return ( ! $this->isOffGrid()) && $this->isOpen($this->position[0] - 1, $this->position[1] + 1);
    }


    private function canMoveRight(): bool
    {
        return $this->isOpen($this->position[0] + 1, $this->position[1] + 1);
        // return ( ! $this->isOffGrid()) && $this->isOpen($this->position[0] + 1, $this->position[1] + 1);
    }


    private function moveDown(): void
    {
        $this->position = [$this->position[0], $this->position[1] + 1];
    }


    private function moveLeft(): void
    {
        $this->position = [$this->position[0] - 1, $this->position[1] + 1];
    }


    private function moveRight(): void
    {
        $this->position = [$this->position[0] + 1, $this->position[1] + 1];
    }


    // private function isOffGrid(): bool
    // {
    //     return
    //         $this->position[0] < $this->dim['minX'] ||
    //         $this->position[0] > $this->dim['maxX'] ||
    //         $this->position[1] < $this->dim['minY'] ||
    //         $this->position[1] > $this->dim['maxY'];
    // }


    private function isOpen($x, $y): bool
    {
        return ( ! isset($this->grid[$x][$y])) && $y < $this->floor;
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$dim = ['minX' => PHP_INT_MAX, 'minY' => PHP_INT_MAX, 'maxX' => PHP_INT_MIN, 'maxY' => PHP_INT_MIN,];

$grid  = [];
$entry = [500, 0];
$total = 0;
$rocks = [];

foreach ($data->rows() as $index => $dataRow) {
    $points = explode(' -> ', $dataRow);
    foreach ($points as $point) {
        $rocks[$index][] = explode(',', $point);
    }
}

$grid[$entry[0]][$entry[1]] = '+';
$dim['minX']                = min($dim['minX'], $entry[0]);
$dim['maxX']                = max($dim['maxX'], $entry[0]);
$dim['minY']                = min($dim['minY'], $entry[1]);
$dim['maxY']                = max($dim['maxY'], $entry[1]);

foreach ($rocks as $rock) {
    for ($i = 0; $i < count($rock) - 1; $i++) {
        $start = [$rock[$i][0], $rock[$i][1]];
        $end   = [$rock[$i + 1][0], $rock[$i + 1][1]];
        for ($x = min($start[0], $end[0]); $x <= max($start[0], $end[0]); $x++) {
            $dim['minX'] = min($dim['minX'], $x);
            $dim['maxX'] = max($dim['maxX'], $x);
            for ($y = min($start[1], $end[1]); $y <= max($start[1], $end[1]); $y++) {
                $dim['minY']  = min($dim['minY'], $y);
                $dim['maxY']  = max($dim['maxY'], $y);
                $grid[$x][$y] = "#";
            }
        }
    }
}

$floor = $dim['maxY'] + 2;
$done  = FALSE;

// foreach (range(1,22) as $item) {
while ( ! $done) {
    $sand = new Sand($entry, $grid, $dim, $floor);
    if ($sand->fall() !== $entry) {
        // $grid[$sand->position[0]][$sand->position[1]] = 'o';
        $dim['minX']                                  = min($dim['minX'], $sand->position[0]);
        $dim['maxX']                                  = max($dim['maxX'], $sand->position[0]);
        $dim['minY']                                  = min($dim['minY'], $sand->position[1]);
        $dim['maxY']                                  = max($dim['maxY'], $sand->position[1]);
    } else {
        $done = TRUE;
    }
    $total++;
    $grid[$sand->position[0]][$sand->position[1]] = 'o';
}

foreach (range($dim['minX'], $dim['maxX']) as $x) {
    $grid[$x][$floor] = '#';
}
$dim['maxY'] = $floor;

draw($grid, $dim);

output("Total: $total");


function draw(&$grid, &$dim)
{
    for ($j = $dim['minY']; $j <= $dim['maxY']; $j++) {
        for ($i = $dim['minX']; $i <= $dim['maxX']; $i++) {
            echo isset($grid[$i][$j]) ? $grid[$i][$j] : '.';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
    echo PHP_EOL;
}
