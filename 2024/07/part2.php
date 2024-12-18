<?php
use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';


//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));

$total = 0;
$retry = [];

function evaluate(array $inputs, string $value, int $base = 2): array
{
    $numOperators = count($inputs) - 1;
    $max          = (1 << $numOperators);
    if ($base === 3) {
        $max = pow(3, $numOperators);
    }

    $flag         = FALSE;

    $operatorArray = [];
    for ($i = 0; $i < $max; $i++) {
        $operatorArray[] = str_pad(base_convert($i, 10, $base), $numOperators, '0', STR_PAD_LEFT);
    }

    foreach ($operatorArray as $operatorString) {
        $operators  = str_split($operatorString);
        $workInputs = $inputs;

        foreach ($operators as $operator) {
            $one    = array_shift($workInputs);
            $two    = array_shift($workInputs);
            $result = match ($operator) {
                '0' => $one + $two,
                '1' => $one * $two,
                '2' => $one . $two,
            };

            if (empty($workInputs) && $result == $value) {
                $flag = TRUE;
                break(2);
            }

            array_unshift($workInputs, $result);
        }

    }
    return array($flag, $result);
}

foreach ($data->rows() as $dataRow) {

    [$value, $inputString] = explode(':', $dataRow);
    $inputs = explode(' ', trim($inputString));

    list($flag, $result) = evaluate($inputs, $value);

    if ($flag) {
        $total += $result;
    } else {
        list($flag, $result) = evaluate($inputs, $value, $base = 3);
        if ($flag) {
            $total += $result;
        }
    }
}


output("Total: " . $total);
