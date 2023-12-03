<?php

class Path
{
    private $path;
    private $position;

    public function __construct($path, $position)
    {
        $this->path     = $path;
        $this->position = $position;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getLength()
    {
        return strlen($this->path);
    }

}


require_once '../../autoload.php';
require_once '../../functions.php';

$passcodes = [
    'ihgpwlah',
    'kglvqrro',
    'ulqzkmiv',
    'mmsxrhfx'
];


foreach ($passcodes as $passcode) {

    $stack    = new SplStack();
    $max      = ['x' => 3, 'y' => 3];
    $start    = ['x' => 0, 'y' => 0];
    $target   = ['x' => 3, 'y' => 3];
    $shortest = new Path(str_repeat('x', 500), $target);
    $longest  = new Path('', $start);

    $path = new Path('', $start);

    $stack->push($path);

// while there's anything on the stack
    while (!$stack->isEmpty()) {
        // pop the top item off the stack
        $path = $stack->pop();

        // if we're at the target, we're done
        if ($path->getPosition() == $target) {
            // if path length is shorter than the shortest path, update the shortest path
            if ($path->getLength() < $shortest->getLength()) {
                $shortest = $path;
            }
            if ($path->getLength() > $longest->getLength()) {
                $longest = $path;
            }
            continue;
        }

        // get the possible moves from the current position
        $moves = getPossibleMoves($passcode, $path->getPath(), $path->getPosition(), $max);

        // if there are no possible moves, we're done
        if (empty($moves)) {
            continue;
        }

        // for each possible move
        foreach ($moves as $move) {
            // push a new path onto the stack
            $stack->push(new Path($path->getPath() . $move['direction'], $move['position']));
        }
    }

    output('Shortest path: ' . $shortest->getPath());
    output('Longest path length: ' . $longest->getLength());
}


// get possible moves from the current position
function getPossibleMoves($passcode, $path, $position, $max)
{
    // initialize the moves array
    $moves = [];

    // get the hash
    $hash = md5($passcode . $path);

    // if the door is open, add the move
    if (isOpen($hash[0]) && $position['y'] > 0) {
        $moves[] = [
            'direction' => 'U',
            'position'  => ['x' => $position['x'], 'y' => $position['y'] - 1]
        ];
    }

    // if the door is open, add the move
    if (isOpen($hash[1]) && $position['y'] < $max['y']) {
        $moves[] = [
            'direction' => 'D',
            'position'  => ['x' => $position['x'], 'y' => $position['y'] + 1]
        ];
    }

    // if the door is open, add the move
    if (isOpen($hash[2]) && $position['x'] > 0) {
        $moves[] = [
            'direction' => 'L',
            'position'  => ['x' => $position['x'] - 1, 'y' => $position['y']]
        ];
    }

    // if the door is open, add the move
    if (isOpen($hash[3]) && $position['x'] < $max['x']) {
        $moves[] = [
            'direction' => 'R',
            'position'  => ['x' => $position['x'] + 1, 'y' => $position['y']]
        ];
    }

    return $moves;
}

function isOpen($char)
{
    return in_array($char, ['b', 'c', 'd', 'e', 'f']);
}
