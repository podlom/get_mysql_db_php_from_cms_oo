<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 15.11.2018
 * Time: 21:52
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class laravelFramework extends baseCms
{
    private $dbConfMap = [
        'host' => 'DB_HOST',
        'name' => 'DB_DATABASE',
        'user' => 'DB_USERNAME',
        'pass' => 'DB_PASSWORD',
    ];

    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        $className = '\Dotenv\Dotenv';
        if (!class_exists($className)) {
            $this->reportText .= $this->commentStart . ' Class ' . $className . ' does not exists. Run composer install' . $this->commentEnd . PHP_EOL;
        } else {
            $data = (new \Dotenv\Dotenv(dirname($this->configFile) . '/../'))->load();
            if (is_array($data) && !empty($data)) {
                foreach ($data as $n1 => $l1) {
                    foreach ($this->dbConfMap as $k2 => $n2) {
                        $foundParam = (substr($l1, 0, strlen($n2)) === $n2);
                        if ($foundParam) {
                            $d3 = explode('=', $l1);
                            $this->dbs[0][$k2] = $d3[1];
                        }
                    }
                }
                if (strlen($this->dbs[0]['name']) > 0
                    && strlen($this->dbs[0]['user']) > 0
                ) {
                    $this->disPlayResults = 1;
                }
            }
        }
    }

    public function detectSetVersion()
    {
    }
}