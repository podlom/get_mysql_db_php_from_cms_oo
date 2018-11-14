<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 13.11.2018
 * Time: 22:08
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class wordpressCms extends baseCms
{
    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'wp-config.php';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        $fileLines = file($this->configFile);
        $numConfigLines = count($fileLines);
        if ($numConfigLines > 0) {
            foreach ($fileLines as $line1) {
                if (preg_match("/define\(\s*?'DB_HOST', '(.+)'\s*?\);/m", $line1, $m3)) {
                    $this->dbs[0]['host'] = $m3[1];
                }
                if (preg_match("/define\(\s*?'DB_NAME', '(.+)'\s*?\);/m", $line1, $m1)) {
                    $this->dbs[0]['name'] = $m1[1];
                }
                if (preg_match("/define\(\s*?'DB_USER', '(.+)'\s*?\);/m", $line1, $m2)) {
                    $this->dbs[0]['user'] = $m2[1];
                }
                if (preg_match("/define\(\s*?'DB_PASSWORD', '(.+)'\s*?\);/m", $line1, $m3)) {
                    $this->dbs[0]['pass'] = $m3[1];
                }
            }
        }
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
        $versionFile = $this->dirName . DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'version.php';
        include_once $versionFile;
        if (isset($wp_version)) {
            $this->version = $wp_version;
        }
    }

    public function setVersionText()
    {
        if (!is_numeric($this->version)) {
            $this->versionText = $this->commentStart . ' Detected WordPress CMS version '  . $this->getVersion() . ' ' . $this->commentEnd . PHP_EOL;
        }
    }
}