<?php

use Utility\FileReader;
use drupol\phpermutations\Generators\Combinations;

require_once '../../vendor/autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
// $data = new FileReader(currentDir('data.txt'));

$weapons = [
    0 => ['Cost' => 8, 'Dam' => 4, 'Arm' => 0],
    1 => ['Cost' => 10, 'Dam' => 5, 'Arm' => 0],
    2 => ['Cost' => 25, 'Dam' => 6, 'Arm' => 0],
    3 => ['Cost' => 40, 'Dam' => 7, 'Arm' => 0],
    4 => ['Cost' => 74, 'Dam' => 8, 'Arm' => 0],
];

$armors = [
    0 => ['Cost' => 0, 'Dam' => 0, 'Arm' => 0],
    1 => ['Cost' => 13, 'Dam' => 0, 'Arm' => 1],
    2 => ['Cost' => 31, 'Dam' => 0, 'Arm' => 2],
    3 => ['Cost' => 53, 'Dam' => 0, 'Arm' => 3],
    4 => ['Cost' => 75, 'Dam' => 0, 'Arm' => 4],
    5 => ['Cost' => 102, 'Dam' => 0, 'Arm' => 5],
];

$rings = [
    0 => ['Cost' => 0, 'Dam' => 0, 'Arm' => 0],
    1 => ['Cost' => 25, 'Dam' => 1, 'Arm' => 0],
    2 => ['Cost' => 50, 'Dam' => 2, 'Arm' => 0],
    3 => ['Cost' => 100, 'Dam' => 3, 'Arm' => 0],
    4 => ['Cost' => 20, 'Dam' => 0, 'Arm' => 1],
    5 => ['Cost' => 40, 'Dam' => 0, 'Arm' => 2],
    6 => ['Cost' => 80, 'Dam' => 0, 'Arm' => 3],
];

$min = 99999999999;
$max = 0;

for ($w = 0; $w < count($weapons); $w++) {
    for ($a = 0; $a < count($armors); $a++) {
        for ($r = 0; $r < count($rings); $r++) {
            for ($z = 0; $z <= $r; $z++) {
                if (($r == 0 && $z == 0) || $z != $r) {
                    $win = FALSE;
                    [$boss, $player] = init();
                    [$dam, $arm, $cost] = getStats($weapons[$w], $armors[$a], $rings[$r], $rings[$z]);
                    $player['Dam'] += $dam;
                    $player['Arm'] += $arm;
                    output($weapons[$w]['Cost'] . '   ' . $armors[$a]['Cost'] . '   ' . $rings[$r]['Cost'] . '   ' . $rings[$z]['Cost']);
                    output(max($player['Dam'] - $boss['Arm'], 1) . '   ' . max($boss['Dam'] - $player['Arm'], 1));

                    while ($player['HP'] > 0 && $boss['HP'] > 0) {
                        // Player's turn
                        $boss['HP'] -= max($player['Dam'] - $boss['Arm'], 1);
                        if ($boss['HP'] <= 0) {
                            $win = TRUE;
                            $min = min($min, $cost);
                        } else {
                            // Boss' turn
                            $player['HP'] -= max($boss['Dam'] - $player['Arm'], 1);
                            if ($player['HP'] <= 0) {
                                $max = max($max, $cost);
                            }
                        }
                        output('Player: ' . $player['HP'] . '   Boss: ' . $boss['HP']);
                    }
                }
                output(($win ? 'Player' : 'Boss') . " wins   Cost: ($cost|$max)");
                output(str_repeat('-', 40));
            }
        }
    }
}


output(str_repeat('=', 40));
output("Minimum winning cost: $min");
output("Maximum losing cost: $max");
output(str_repeat('=', 40));


function init()
{
    // $bossInit = ['HP' => 12, 'Dam' => 7, 'Arm' => 2,];
    $bossInit = ['HP' => 103, 'Dam' => 9, 'Arm' => 2,];
    // $playerInit = ['HP' => 8, 'Dam' => 5, 'Arm' => 5,];
    $playerInit = ['HP' => 100, 'Dam' => 0, 'Arm' => 0,];

    return [$bossInit, $playerInit, NULL, NULL, NULL, NULL,];
}

function getStats($weapon, $armor, $ring1, $ring2)
{
    return [
        $weapon['Dam'] + $armor['Dam'] + $ring1['Dam'] + $ring2['Dam'],
        $weapon['Arm'] + $armor['Arm'] + $ring1['Arm'] + $ring2['Arm'],
        $weapon['Cost'] + $armor['Cost'] + $ring1['Cost'] + $ring2['Cost'],
    ];
}
