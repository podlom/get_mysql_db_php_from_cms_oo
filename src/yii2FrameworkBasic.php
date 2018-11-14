<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 2:14
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class yii2FrameworkBasic extends baseCms
{
    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'db.php';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        echo $this->commentStart . ' Yii 2+ Framework basic application template DB config: ' . $this->configFile . ' ' . $this->commentEnd . PHP_EOL;
        $dbParams = require $this->configFile;
        if (isset($dbParams['dsn'])) {
            $p1 = explode(':', $dbParams['dsn']);
            if ($p1[0] == 'mysql') {
                $p2 = explode(';', $p1[1]);
                if (count($p2) == 2) {
                    $p3 = explode('=', $p2[0]);
                    if ($p3[0] == 'host') {
                        $this->dbs[0]['host'] = $p3[1];
                    } elseif ($p3[0] == 'dbname') {
                        $this->dbs[0]['name'] = $p3[1];
                    }
                    $p4 = explode('=', $p2[1]);
                    if ($p4[0] == 'dbname') {
                        $this->dbs[0]['name'] = $p4[1];
                    } elseif ($p4[0] == 'host') {
                        $this->dbs[0]['host'] = $p4[1];
                    }
                    $this->dbs[0]['user'] = $dbParams['username'];
                    $this->dbs[0]['pass'] = $dbParams['password'];
                    if (strlen($this->dbs[0]['host']) > 0
                        && strlen($this->dbs[0]['name']) > 0
                        && strlen($this->dbs[0]['user']) > 0
                    ) {
                        $this->disPlayResults = 1;
                    }
                }
            } else {
                echo $this->commentStart . ' Error: can`t generate script for non-MySQL database: ' . $p1[0] . ' ' . $this->commentEnd . PHP_EOL;
            }
        }
    }

    public function detectSetVersion()
    {
    }
}