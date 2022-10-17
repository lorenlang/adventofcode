<?php
/**
 * Created by PhpStorm.
 * User: llang
 * Date: 6/27/17
 * Time: 12:35 PM
 */

class Autoloader {

    static public function loader($className) {
        list($path) = get_included_files();
        $filename = dirname($path) . '/' . str_replace('\\', '/', $className) . '.php';
        // $filename = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

spl_autoload_register('Autoloader::loader');
