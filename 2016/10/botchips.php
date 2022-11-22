<?php


class Bot
{

    public $lowRcpt;
    public $highRcpt;

    private $chips = [];


    public function count()
    {
        return count($this->chips);
    }


    public function hasInstructions()
    {
        return ( ! empty($this->lowRcpt)) && ( ! empty($this->highRcpt));
    }


    public function lowChip()
    {
        return empty($this->chips) ? -1 : min($this->chips);
    }


    public function highChip()
    {
        return empty($this->chips) ? -1 : max($this->chips);
    }


    public function addChip($chipNum)
    {
        if (count($this->chips) < 2) {
            $this->chips[] = $chipNum;
        }
    }


    public function removeChip($chipNum)
    {
        foreach ($this->chips as $index => $chip) {
            if ($chip == $chipNum) {
                unset($this->chips[$index]);
            }
        }
    }


    /**
     * @return mixed
     */
    public function getLowRcpt()
    {
        return $this->lowRcpt;
    }


    /**
     * @param mixed $lowRcpt
     */
    public function setLowRcpt($lowRcpt): void
    {
        $this->lowRcpt = $lowRcpt;
    }


    /**
     * @return mixed
     */
    public function getHighRcpt()
    {
        return $this->highRcpt;
    }


    /**
     * @param mixed $highRcpt
     */
    public function setHighRcpt($highRcpt): void
    {
        $this->highRcpt = $highRcpt;
    }


}


class Output
{
    private $chips = [];


    public function addChip($chipNum)
    {
        if (count($this->chips) < 2) {
            $this->chips[] = $chipNum;
        }
    }


    public function getChip()
    {
        return empty($this->chips) ? -1 : min($this->chips);
    }

}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

$done   = FALSE;
$bot    = [];
$output = [];
$value  = [];
$target = [61, 17];


while ( ! $done) {

    // $data = new FileReader(currentDir('test.txt'));
    $data = new FileReader(currentDir('data.txt'));

    foreach ($data->rows() as $row) {

        if ( ! $done) {

            [$command, $parms] = explode(' ', $row, 2);
            switch ($command) {
                case 'bot':
                    [$botNum, , , , $lowType, $lowNum, , , , $highType, $highNum] = explode(' ', $parms);
                    if ( ! array_key_exists($botNum, $bot)) {
                        $bot[$botNum] = new Bot();
                    }
                    if ( ! array_key_exists($lowNum, $$lowType)) {
                        $$lowType[$lowNum] = $lowType == 'bot' ? new Bot() : new Output();
                    }
                    if ( ! array_key_exists($highNum, $$highType)) {
                        $$highType[$highNum] = $highType == 'bot' ? new Bot() : new Output();
                    }
                    $bot[$botNum]->setLowRcpt(['type' => $lowType, 'num' => $lowNum]);
                    $bot[$botNum]->setHighRcpt(['type' => $highType, 'num' => $highNum]);
                    break;

                case 'value':
                    [$chipNum, , , , $botNum] = explode(' ', $parms);
                    if ( ! array_key_exists($botNum, $bot)) {
                        $bot[$botNum] = new Bot();
                    }
                    $bot[$botNum]->addChip($chipNum);
                    break;
            }
        }


        foreach (getReadyBots($bot) as $id) {

            if ($bot[$id]->lowChip() == min($target) && $bot[$id]->highChip() == max($target)) {
                output("Bot with target:  $id");
                $done = TRUE;
            }

            /* @var Bot $bot */
            if ($bot[$id]->hasInstructions()) {
                $lowType = $bot[$id]->getLowRcpt()['type'];
                $lowNum  = $bot[$id]->getLowRcpt()['num'];
                $$lowType[$lowNum]->addChip($bot[$id]->lowChip());
                $bot[$id]->removeChip($bot[$id]->lowChip());

                $highType = $bot[$id]->getHighRcpt()['type'];
                $highNum  = $bot[$id]->getHighRcpt()['num'];
                $$highType[$highNum]->addChip($bot[$id]->highChip());
                $bot[$id]->removeChip($bot[$id]->highChip());
            }
        }
    }

}

$value = $output[0]->getChip() * $output[1]->getChip() * $output[2]->getChip();
output("Value:  $value");


function getReadyBots($bots)
{
    return array_keys(array_filter($bots, function ($bot) {
        return $bot->count() == 2;
    }));
}
