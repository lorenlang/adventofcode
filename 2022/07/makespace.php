<?php


class ElfDirectory
{

    public $name;
    public $parent;
    public $children = [];
    public $files    = [];


    /**
     * @param $name
     */
    public function __construct($name, $parent)
    {
        $this->name   = $name;
        $this->parent = $parent;
    }


}

class ElfFile
{

    public $name;
    public $size;


    /**
     * @param $name
     * @param $size
     */
    public function __construct($name, $size)
    {
        $this->name = $name;
        $this->size = $size;
    }


}


use Utility\FileReader;

require_once '../../autoload.php';
require_once '../../functions.php';
require_once '../../utility/FileReader.php';

// $data = new FileReader(currentDir('test.txt'));
$data = new FileReader(currentDir('data.txt'));


$commands = [];
$dirs     = [];
$current  = NULL;
$stack    = [];

foreach ($data->rows() as $dataRow) {
    $commands[] = $dataRow;
}


while ($commands) {

    $command = array_shift($commands);

    if ($command[0] == '$') {

        if (substr($command, 2, 2) == 'cd') {
            [, , $destDir] = explode(' ', $command);

            if ($destDir == '..') {
                $current = $dirs[$current->parent];
                array_pop($stack);
            } else {
                array_push($stack, $destDir);
                $path = getPath($stack);
                if ( ! array_key_exists($path, $dirs)) {
                    $dirs[$path] = new ElfDirectory($path, $current ? $current->name : '');
                    if ($current) {
                        $current->children[] = $path;
                    }
                }
                $current = $dirs[$path];
            }
        }

        if (substr($command, 2, 2) == 'ls') {
            while ($line = array_shift($commands)) {
                if ($line[0] == '$') {
                    array_unshift($commands, $line);
                    break;
                } else {
                    [$parm1, $name] = explode(' ', $line);
                    if ($parm1 == 'dir') {
                        $path        = getPath($stack) . "|$name";
                        $dirs[$path] = new ElfDirectory($path, $current->name);
                        if ($current) {
                            $current->children[] = $path;
                        }
                    } else {
                        $current->files[] = new ElfFile($name, $parm1);
                    }
                }
            }
        }

    }

}

$total = 70000000 - calculateSize($dirs['/'], $dirs);
$sum   = 0;
$min   = PHP_INT_MAX;
foreach ($dirs as $dir) {
    $size = calculateSize($dir, $dirs);

    if ($size <= 100000) {
        $sum += $size;
    }
    if ($size >= 30000000 - $total) {
        $min = min($min, $size);
    }
}

output("Total: $sum");
output("Min: $min");



function calculateSize($dir, &$dirs)
{
    $size = 0;
    foreach ($dir->files as $file) {
        $size += $file->size;
    }
    foreach ($dir->children as $child) {
        $size += calculateSize($dirs[$child], $dirs);
    }

    return $size;
}


function getPath($stack)
{
    return join('|', $stack);
}
