<?php
/**
 * Created by PhpStorm.
 * User: llang
 * Date: 11/27/18
 * Time: 3:30 PM
 */

if ( ! function_exists('l')) {

    function l($stuff)
    {
        $dev_log = '/var/log/dev.log';
        $stuff   = timestamp() . ":\n" . var_export($stuff, TRUE) . "\n" . str_repeat('-', 30) . "\n";
        error_log($stuff, 3, $dev_log);
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('timestamp')) {

    function timestamp()
    {
        return date('Y-m-d H:i:s');
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('output')) {

    function output($str = '')
    {
        echo $str . PHP_EOL;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('currentDir')) {

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

function isEven(int $int):bool
{
    return $int % 2 === 0;
}
