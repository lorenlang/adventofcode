<?php
/**
 * Created by PhpStorm.
 * User: llang
 * Date: 11/27/18
 * Time: 3:30 PM
 */

if (!function_exists('l')) {

    function l($stuff, $suppress = FALSE)
    {
        $dev_log = '/var/log/dev.log';
        if ($suppress) {
            $stuff = var_export($stuff, TRUE) . "\n";
        } else {
            $stuff = timestamp() . ":\n" . var_export($stuff, TRUE) . "\n" . str_repeat('-', 30) . "\n";
        }
        error_log($stuff, 3, $dev_log);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('timestamp')) {

    function timestamp()
    {
        return date('Y-m-d H:i:s');
    }
}

// ------------------------------------------------------------------------

if (!function_exists('output')) {

    function output(string $str = '', string|null $filename = ''): void
    {
        if ($filename) {
        $filename = getcwd() . '/' . $filename;
            file_put_contents($filename, $str . PHP_EOL, FILE_APPEND);
        } else {
            echo $str . PHP_EOL;
        }
    }
}

// ------------------------------------------------------------------------

if (!function_exists('dashline')) {

    function dashline(int $len = 40, string|null $filename = ''): void
    {
        output(str_repeat('-', $len), $filename);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('currentDir')) {

    function currentDir($filename)
    {
        return exec('pwd') . '/' . $filename;
    }
}

// ------------------------------------------------------------------------

function array_wrap($value)
{
    if (is_null($value)) {
        return [];
    }

    return is_array($value) ? $value : [$value];
}

// ------------------------------------------------------------------------

# URL Check
function url_check($url)
{
    $headers = @get_headers($url);

    return is_array($headers) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/', $headers[0]) : FALSE;
}

// ------------------------------------------------------------------------

function stripRegex($str, $regex, $repl = ''): string
{
    return trim(preg_replace($regex, $repl, $str));
}

// ------------------------------------------------------------------------

function stripNonAlphaNumeric($str, $repl = ''): string
{
    return stripRegex($str, '/[^A-Za-z0-9]/', $repl);
}

// ------------------------------------------------------------------------

function stripNonAlphabetic($str, $repl = ''): string
{
    return stripRegex($str, '/[^A-Za-z]/', $repl);
}

// ------------------------------------------------------------------------

function isEven(int $int): bool
{
    return $int % 2 === 0;
}

// ------------------------------------------------------------------------

function isOdd(int $int): bool
{
    return $int % 2 !== 0;
}

// ------------------------------------------------------------------------

function array_flatten(array $array): array
{
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
        $return[] = $a;
    });
    return $return;
}

// ------------------------------------------------------------------------

function drawGrid($grid): void
{
    for ($i = 0, $iMax = count($grid); $i < $iMax; $i++) {
        for ($j = 0, $jMax = count($grid[$i]); $j < $jMax; $j++) {
            echo $grid[$i][$j]['curr'] ? '#' : '.';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
    echo PHP_EOL;
}

// ------------------------------------------------------------------------


