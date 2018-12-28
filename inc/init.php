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

if (file_exists(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php')) {
    require_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

spl_autoload_register(function ($className) {
    $p = strpos($className, '\\');
    if ($p !== false) {
        $className = substr($className, $p + 1, strlen($className));
    }
    $classFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    } else {
        die(__FUNCTION__ . ' class file ' . $classFile . ' does not exists.' . PHP_EOL);
    }
});
