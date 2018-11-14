<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 1:31
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class detectManager
{
    private $dirName = null;
    private $commentStart = '';
    private $commentEnd = '';
    private $cmsConfigs = [
        'getMysqlCms\\wordpressCms' => 'wp-config.php',
        'getMysqlCms\\drupalCmf' => 'sites' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'settings.php',
        'getMysqlCms\\yii2FrameworkBasic' => 'config' . DIRECTORY_SEPARATOR . 'db.php',
        'getMysqlCms\\yii2FrameworkAdvanced' => 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main-local.php',
        'getMysqlCms\\joomlaCms' => 'configuration.php',
        'getMysqlCms\\magentoCms' => 'app' . DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'local.xml',
    ];
    private $dbs = [];
    private $reportText = '';
    private $disPlayResults = 0;

    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        if (!empty($dirName)) {
            $this->dirName = $dirName;
        }
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->detectCms();
    }

    public function getDbs()
    {
        return $this->dbs;
    }

    public function getReportText()
    {
        return $this->reportText;
    }

    public function displayResults()
    {
        return $this->disPlayResults;
    }

    private function detectCms()
    {
        foreach ($this->cmsConfigs as $c1 => $v1) {
            $configFileName = $this->dirName . $v1;
            $this->reportText .= __METHOD__ . ' +' . __LINE__ . ' Checking ' . $configFileName . '...' . PHP_EOL;
            if (file_exists($configFileName)) {
                $cms = new $c1($this->dirName, $this->commentStart, $this->commentEnd);
                break;
            } else {
                $this->reportText .= __METHOD__ . ' +' . __LINE__ . ' File ' . $configFileName . ' was not found.' . PHP_EOL;
            }
        }
        if (!empty($cms)) {
            $cms->detectCMS();
            $this->dbs = $cms->getDbs();
            $this->reportText .= $cms->getReportText();
            $this->disPlayResults = $cms->displayResults();
        } else {
            $this->reportText .= __METHOD__ . ' +' . __LINE__ . ' CMS was not detected!' . PHP_EOL;
        }
    }
}