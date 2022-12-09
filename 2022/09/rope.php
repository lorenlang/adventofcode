<?php


class Node
{
    public int $x;
    public int $y;


    public function __construct()
    {
        $this->x = 0;
        $this->y = 0;
    }
}


class Head extends Node
{

    public function move($dir)
    {
        switch ($dir) {
            case 'U':
                $this->x++;
                break;

            case 'D':
                $this->x--;
                break;

            case 'L':
                $this->y--;
                break;

            case 'R':
                $this->y++;
                break;
        }
    }
}


class Tail extends Node
{

    private array $visited = [];


    public function __construct()
    {
        parent::__construct();
        $this->logPostition();
    }


    public function logPostition()
    {
        $pos = $this->x . ' ' . $this->y;
        if ( ! in_array($pos, $this->visited)) {
            $this->visited[] = $pos;
        }

        return $pos;
    }


    public function trail(Node $node)
    {
        if ( ! $this->isAdjacent($node)) {
            $this->move($this->plotMove($node));
        }
        $this->logPostition();
    }


    private function move(array $adj)
    {
        $this->x += $adj['x'];
        $this->y += $adj['y'];
    }


    private function isAdjacent(Node $node)
    {
        return (abs($node->x - $this->x) < 2) && (abs($node->y - $this->y) < 2);
    }


    private function plotMove(Node $node)
    {
        $x = 0;
        $y = 0;

        if (abs($node->x - $this->x) > 0) {
            $x = $node->x < $this->x ? -1 : 1;
        }
        if (abs($node->y - $this->y) > 0) {
            $y = $node->y < $this->y ? -1 : 1;
        }

        return ['x' => $x, 'y' => $y];
    }


    public function numVisited()
    {
        return count($this->visited);
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$head = new Head();
$tail = new Tail();

foreach ($data->rows() as $dataRow) {

    [$dir, $num] = explode(' ', $dataRow);
    for ($i = 0; $i < $num; $i++) {
        $head->move($dir);
        $tail->trail($head);
    }
}

// var_dump($head);
// var_dump($tail);


output("Visited: " . $tail->numVisited());
