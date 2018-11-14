<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 2:54
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class magentoCms extends baseCms
{
    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'local.xml';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        if (!function_exists('simplexml_load_file')) {
            echo 'Error: can`t work without simplexml_load_file function.' .
                ' Please install SimpleXml support in PHP.' . PHP_EOL;
            return 4;
        }
        $xmlConfig = simplexml_load_file($this->configFile);
        $conn = $xmlConfig->global->resources->default_setup->connection;
        $this->dbs[0]['host'] = (string) $conn->host;
        $this->dbs[0]['name'] = (string) $conn->dbname;
        $this->dbs[0]['user'] = (string) $conn->username;
        $this->dbs[0]['pass'] = (string) $conn->password;
        if (strlen($this->dbs[0]['name']) > 0
            && strlen($this->dbs[0]['user']) > 0
        ) {
            $this->disPlayResults = 1;
        }
        $this->detectSetVersion();
        $this->setVersionText();
    }

    public function detectSetVersion()
    {
        $verFile = $this->dirName . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
        if (file_exists($verFile)) {
            include_once $verFile;
            $this->version = Mage::getVersion();
        }
    }

    public function setVersionText()
    {
        if (!empty($this->version)) {
            $this->versionText = $this->commentStart . ' version: '  . $this->getVersion() . ' ' . $this->commentEnd . PHP_EOL;
        }
    }
}