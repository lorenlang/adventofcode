<?php


class Monkey
{

    private $items = [];
    private $current;

    public $megaMod;

    public $testDivisor;
    public $operator;
    public $coefficient;
    public $trueMonkey;
    public $falseMonkey;

    public $inspections;


    /**
     * @param $testDivisor
     * @param $operator
     * @param $coefficient
     * @param $trueMonkey
     * @param $falseMonkey
     */
    public function __construct($testDivisor, $operator, $coefficient, $trueMonkey, $falseMonkey)
    {
        $this->testDivisor = $testDivisor;
        $this->operator    = $operator;
        $this->coefficient = $coefficient;
        $this->trueMonkey  = $trueMonkey;
        $this->falseMonkey = $falseMonkey;
        $this->inspections = 0;
    }


    public function addItem($item)
    {
        array_push($this->items, $item);
    }


    public function nextItem()
    {
        $this->inspections++;
        $this->current = array_shift($this->items);
        $this->doOperation();
        $this->reduceWorry();

        return [$this->current, $this->doTest() ? $this->trueMonkey : $this->falseMonkey];
    }


    public function clear()
    {
        $this->current = NULL;
    }


    public function hasItems()
    {
        return count($this->items) > 0;
    }


    private function doOperation()
    {
        if ($this->operator == '+') {
            $this->current += $this->coefficient;
        } else if ($this->operator == '*') {
            $coefficient   = $this->coefficient == 'old' ? $this->current : $this->coefficient;
            $this->current *= $coefficient;
        }

    }


    public function doTest()
    {
        return $this->current % $this->testDivisor === 0;
    }


    private function reduceWorry()
    {
        // $this->current = floor($this->current / 3);
        $this->current = $this->current % $this->megaMod;
    }
}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$monkeys   = [];
$infos     = [];
$count     = [];
$mods      = [];
$numRounds = 10000;

foreach ($data->rows() as $dataRow) {

    if (substr($dataRow, 0, 6) == 'Monkey') {
        [, $num] = explode(' ', str_replace(':', '', $dataRow));
    } else {
        $infos[$num][] = $dataRow;
    }

}
foreach ($infos as $index => $info) {
    [, $items] = explode(':', $info[0]);
    $items = explode(', ', trim($items));

    [, $op] = explode('= old ', $info[1]);
    [$operator, $coefficient] = explode(' ', trim($op));

    [, $testDivisor] = explode('by ', $info[2]);

    [, $trueMonkey] = explode('monkey ', $info[3]);
    [, $falseMonkey] = explode('monkey ', $info[4]);

    $monkeys[$index] = new Monkey($testDivisor, $operator, $coefficient, $trueMonkey, $falseMonkey);
    foreach ($items as $item) {
        $monkeys[$index]->addItem($item);
    }

    $mods[] = $testDivisor;
}

foreach ($monkeys as $monkey) {
    $monkey->megaMod = array_product($mods);
}


for ($i = 0; $i < $numRounds; $i++) {
    output('Round: ' . ($i + 1));
    foreach ($monkeys as $monkey) {
        while ($monkey->hasItems()) {
            [$item, $rcpt] = $monkey->nextItem();
            $monkeys[$rcpt]->addItem($item);
            $monkey->clear();
        }
    }
}

foreach ($monkeys as $monkey) {
    $count[] = $monkey->inspections;
}
sort($count);

$total = array_pop($count) * array_pop($count);
output("Total: $total");
