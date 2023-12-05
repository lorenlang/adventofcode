<?php

require_once '../../autoload.php';
require_once '../../functions.php';

//$numElves = 5;
$numElves = 3017957;


$elves = range(1, $numElves);
$current = 0;

while (count($elves) > 1) {

//    output('Elf ' . $current . ' is stealing');
    $next = getNext($elves, $current, $numElves);
//    output('Elf ' . $current . ' steals from ' . $next);
//    output('Elf ' . $next . ' is removed');
    unset($elves[$next]);
//    output('Remaining: ' . count($elves));
//    output('-------------------');
    $current = getNext($elves, $next, $numElves);

}

output('Elf ' . $elves[$current] . ' is the winner');


function getNext($elves, $current, $max)
{
    do {
        $current++;
        if ($current >= $max) {
            $current = 0;
        }
    } while (!isset($elves[$current]));

//    output('Elf ' . $current . ' is next');
    return $current;
}
