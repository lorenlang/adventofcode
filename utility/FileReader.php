<?php

namespace Utility;

class FileReader
{

    protected $file;


    public function __construct($filePath)
    {
        $this->file = fopen($filePath, 'r');
    }


    public function rows($parseCSV = false)
    {
        while ( ! feof($this->file)) {
            $row = $parseCSV ? fgetcsv($this->file) : fgets($this->file);
            if ( ! empty($row)) {
                yield $row;
            }
        }

        return;
    }

}
