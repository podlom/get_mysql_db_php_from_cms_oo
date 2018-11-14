<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 13.11.2018
 * Time: 22:37
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


spl_autoload_register(function ($className) {
    // echo __FUNCTION__ . ' +' . __LINE__ . ' class name: ' . var_export($className, 1) . PHP_EOL;
    $p = strpos($className, '\\');
    if ($p !== false) {
        $className = substr($className, $p + 1, strlen($className));
        // echo __FUNCTION__ . ' +' . __LINE__ . ' class name: ' . var_export($className, 1) . PHP_EOL;
    }
    // echo __FUNCTION__ . ' $p: ' . var_export($p, 1) . PHP_EOL;
    $classFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    } else {
        echo __FUNCTION__ . ' class file ' . $classFile . ' does not exists.' . PHP_EOL;
    }
});
