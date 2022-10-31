<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

foreach ($data->rows() as $row) {

    $srch = [':', ',',];
    $repl = ['', '',];
    $row  = str_replace($srch, $repl, $row);

    [, , $capacity, , $durability, , $flavor, , $texture, , $calories] = explode(' ', $row);

    $ingredients[] = [
        'capacity'   => $capacity,
        'durability' => $durability,
        'flavor'     => $flavor,
        'texture'    => $texture,
        'calories'   => $calories,
    ];

}

$best = 0;

for ($i = 0; $i <= 100; $i++) {
    for ($j = 0; $j <= 100 - $i; $j++) {
        for ($k = 0; $k <= 100 - $i - $j; $k++) {
            $l = 100 - $i - $j - $k;

            // $capacity   = max(0, ($ingredients[0]['capacity'] * $i) + ($ingredients[1]['capacity'] * (100 - $i)));
            // $durability = max(0, ($ingredients[0]['durability'] * $i) + ($ingredients[1]['durability'] * (100 - $i)));
            // $flavor     = max(0, ($ingredients[0]['flavor'] * $i) + ($ingredients[1]['flavor'] * (100 - $i)));
            // $texture    = max(0, ($ingredients[0]['texture'] * $i) + ($ingredients[1]['texture'] * (100 - $i)));
            // $calories   = ($ingredients[0]['calories'] * $i) + ($ingredients[1]['calories'] * (100 - $i));
            $capacity   = max(0,
                              ($ingredients[0]['capacity'] * $i) + ($ingredients[1]['capacity'] * $j) + ($ingredients[2]['capacity'] * $k) + ($ingredients[3]['capacity'] * $l));
            $durability = max(0,
                              ($ingredients[0]['durability'] * $i) + ($ingredients[1]['durability'] * $j) + ($ingredients[2]['durability'] * $k) + ($ingredients[3]['durability'] * $l));
            $flavor     = max(0,
                              ($ingredients[0]['flavor'] * $i) + ($ingredients[1]['flavor'] * $j) + ($ingredients[2]['flavor'] * $k) + ($ingredients[3]['flavor'] * $l));
            $texture    = max(0,
                              ($ingredients[0]['texture'] * $i) + ($ingredients[1]['texture'] * $j) + ($ingredients[2]['texture'] * $k) + ($ingredients[3]['texture'] * $l));
            $calories   = ($ingredients[0]['calories'] * $i) + ($ingredients[1]['calories'] * $j) + ($ingredients[2]['calories'] * $k) + ($ingredients[3]['calories'] * $l);


            if ($calories == 500) {
                $best = max($best, $capacity * $durability * $flavor * $texture);
            }
            // $j = 100 - $i;
            // $score = $capacity * $durability * $flavor * $texture;
            // output("[$i|$j]    $capacity    $durability    $flavor    $texture    =    " . ($capacity * $durability * $flavor * $texture) . "  ($calories)");
        }
    }
}

output($best);

// print_r($ingredients);
