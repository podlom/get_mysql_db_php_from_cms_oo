<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 13:08
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class reportResults
{
    const INI = '1';
    const CREATE = '2';
    const DROP = '3';

    private static $reportText = '';
    private static $template = [];

    public static function init($dbs, $reportText, $displayResults = 1)
    {
        $sHead = $reportText;
        if ($displayResults == 1) {
            self::$template[self::INI] = <<<EOM
{$sHead}
#
# Example usage in mysql, mysqldump parameter: --defaults-file=.my.cnf
# to make backup run command:
# $ mysqldump --defaults-file=.my.cnf {$dbs[0]['name']} > {$dbs[0]['name']}.sql
# to restore database from backup run command:
# $ mysql --defaults-file=.my.cnf {$dbs[0]['name']} < {$dbs[0]['name']}.sql 
# Save output below as .my.cnf file and run command: chmod -v 600 .my.cnf
#
[client]
host='{$dbs[0]['host']}'
user='{$dbs[0]['user']}'
password='{$dbs[0]['pass']}'

EOM;
        } else {
            self::$template[self::INI] = $reportText;
        }
        $sSql = $sHead = '';
        $numDbs = 0;
        if ($displayResults == 1) {
            if (is_array($dbs) && !empty($dbs)) {
                foreach ($dbs as $db) {
                    $sSql .= 'CREATE DATABASE `' . $db['name'] .
                        '` /*!40100 DEFAULT CHARACTER SET utf8 */;' . PHP_EOL .
                        'GRANT ALL ON `' . $db['name'] .
                        '`.* TO ' . "'" . $db['user'] .
                        "'@'" . $db['host'] . "'" . ' IDENTIFIED BY ' .
                        "'" . $db['pass'] . "'" . ';' . PHP_EOL;
                    ++ $numDbs;
                }
            }
            $sHead .= $reportText;
            $sHead .= self::$reportText;
            $sHead .= 'Set up user and database script is:';
            if ($numDbs > 1) {
                $sHead = 'Set up users and databases script is:';
            }
            self::$template[self::CREATE] = <<<EOM
{$sHead}

{$sSql}
FLUSH PRIVILEGES;
EOM;
        } else {
            self::$template[self::CREATE] = $reportText;
        }
        $sHead = $sSql = '';
        $numDbs = 0;
        if ($displayResults == 1) {
            if (is_array($dbs) && !empty($dbs)) {
                foreach ($dbs as $db) {
                    $sSql .= 'DROP DATABASE `' . $db['name'] . '`;' . PHP_EOL .
                        'DROP USER ' . "'" . $db['user'] . "'@'" . $db['host'] . "'" . ';' . PHP_EOL;
                    ++ $numDbs;
                }
            }
            $sHead .= $reportText;
            $sHead .= self::$reportText;
            $sHead .= 'Drop database & user SQL script is:';
            if ($numDbs > 1) {
                $sHead = 'Drop databases & users SQL scripts are:';
            }
            self::$template[self::DROP] = <<<EOM
{$sHead}

{$sSql}
FLUSH PRIVILEGES;

EOM;
        } else {
            self::$template[self::DROP] = $reportText;
        }
    }

    public static function getReport($id)
    {
        if (isset(self::$template[$id])) {
            return self::$template[$id];
        }
        return false;
    }

    public static function add($text)
    {
        self::$reportText .= $text;
    }
}
