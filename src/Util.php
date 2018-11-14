<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 13.11.2018
 * Time: 22:31
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class Util
{
    private static $scriptName = null;

    public static function printUsage()
    {
        echo "Script usage: php " . self::$scriptName . " '" . DIRECTORY_SEPARATOR . "path" . DIRECTORY_SEPARATOR . "to" . DIRECTORY_SEPARATOR . "folder'" . PHP_EOL;
    }

    public static function setScriptName($scriptName)
    {
        self::$scriptName = $scriptName;
    }
}