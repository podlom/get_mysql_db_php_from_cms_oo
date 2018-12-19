<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 2:40
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class joomlaCms extends baseCms
{
    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'configuration.php';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        include_once $this->configFile;
        $jc1 = new JConfig;
        $this->reportText .= $this->commentStart . ' Detected Joomla! CMS ' . trim($this->getVersionText() . ' ') . $this->commentEnd . PHP_EOL;
        $this->dbs[0]['host'] = $jc1->host;
        $this->dbs[0]['name'] = $jc1->db;
        $this->dbs[0]['user'] = $jc1->user;
        $this->dbs[0]['pass'] = $jc1->password;
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
        $verFile = $this->dirName . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'version' . DIRECTORY_SEPARATOR . 'version.php';
        if (file_exists($verFile)) {
            define('_JEXEC', 1);
            include_once $verFile;
            $jv1 = new JVersion;
            $this->version = $jv1->RELEASE;
        }
    }

    public function setVersionText()
    {
        if (!empty($this->version)) {
            $this->versionText = $this->commentStart . ' version: '  . $this->getVersion() . ' ' . $this->commentEnd . PHP_EOL;
        }
    }
}