<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 13.11.2018
 * Time: 22:06
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


abstract class baseCms implements detectableInterface
{
    protected $dbs = [];
    protected $dirName = null;
    protected $configFile = null;
    protected $disPlayResults = 0;
    protected $version = null;
    protected $versionText = '';
    protected $commentStart = '';
    protected $commentEnd = '';
    protected $reportText = '';

    protected function setDefaultDbsValue()
    {
        $this->dbs[0] = [
            'host' => 'localhost',
            'name' => '',
            'user' => '',
            'pass' => '',
        ];
    }

    public function getDbs()
    {
        return $this->dbs;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getVersionText()
    {
        return $this->versionText;
    }

    public function setDirName($dirName)
    {
        $this->dirName = $dirName;
    }

    public function addToReport($text)
    {
        $this->reportText .= $text;
    }

    public function getReportText()
    {
        return $this->reportText;
    }

    public function displayResults()
    {
        return $this->disPlayResults;
    }
}