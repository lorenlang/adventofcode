<?php

namespace Utility;

class FileReader
{

    protected $file;


    public function __construct($filePath)
    {
        $this->file = fopen($filePath, 'r');
    }


    public function rows($allowBlank = false, $parseCSV = false)
    {
        while ( ! feof($this->file)) {
            $row = trim($parseCSV ? fgetcsv($this->file) : fgets($this->file));

            if ( ! empty($row) || $row === '0' || $allowBlank) {
                yield $row;
            }
        }

        return;
    }

}
