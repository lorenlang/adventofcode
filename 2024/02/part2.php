<?php

use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

//$data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


enum Operator: int {
    case DEC = 0;
    case INC = 1;
}


// class for Report
class Report {
    public bool $safe = true;
    private array $values;

    public function __construct(string $values, int|null $removeNumber = null) {
        $this->values = explode(' ', $values);
        if ($removeNumber !== null) {
            unset($this->values[$removeNumber]);
            $this->values = array_values($this->values);
        }

        $this->safe = $this->checkSafe();
    }


    public function numValues(): int {
        return count($this->values);
    }


    private function checkSafe(): bool {
        $operator = $this->values[0] < $this->values[1] ? Operator::INC : Operator::DEC;

        for ($i = 0, $iMax = count($this->values) - 1; $i < $iMax; $i++) {
            if ($operator === Operator::INC) {
                if( !(($this->values[$i] < $this->values[$i + 1]) && ($this->values[$i + 1] - $this->values[$i] <= 3))) {
                    return false;
                }
            } else {
                if( !(($this->values[$i] > $this->values[$i + 1]) && ($this->values[$i] - $this->values[$i + 1] <= 3))) {
                    return false;
                }

            }
        }

        return true;
    }
}


$safe = 0;

foreach ($data->rows() as $dataRow) {

    $report = new Report($dataRow);
    if ($report->safe) {
        $safe++;
    } else {

        for ($i = 0; $i < $report->numValues(); $i++) {
            $tempReport = new Report($dataRow, $i);
            if ($tempReport->safe) {
                $safe++;
                break;
            }
        }

    }

}

output("Safe: $safe");

