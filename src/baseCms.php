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


/**
 * Class baseCms
 * @package getMysqlCms
 */
abstract class baseCms implements detectableInterface
{
    /**
     * @var array MySQL databases
     */
    protected $dbs = [];

    /**
     * @var null|string CMS directory name
     */
    protected $dirName = null;

    /**
     * @var null|string CMS config file name
     */
    protected $configFile = null;

    /**
     * @var int display results flag
     */
    protected $disPlayResults = 0;

    /**
     * @var null|string CMS version number
     */
    protected $version = null;

    /**
     * @var string CMS version text string
     */
    protected $versionText = '';

    /**
     * @var string block of comments start symbol
     */
    protected $commentStart = '';

    /**
     * @var string block of comments end symbol
     */
    protected $commentEnd = '';

    /**
     * @var string report text string
     */
    protected $reportText = '';

    /**
     * Set default DBs value
     */
    protected function setDefaultDbsValue()
    {
        $this->dbs[0] = [
            'host' => 'localhost',
            'name' => '',
            'user' => '',
            'pass' => '',
        ];
    }

    /**
     * Getter for @var $this->dbs
     * @return array DBs getter
     */
    public function getDbs()
    {
        return $this->dbs;
    }

    /**
     * Getter for @var $this->version
     * @return string|null CMS version getter
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Getter for @var $this->versionText
     * @return string CMS version text getter
     */
    public function getVersionText()
    {
        return $this->versionText;
    }

    /**
     * Setter for @var $this->dirName
     * @param $dirName string CMS directory name setter
     */
    public function setDirName($dirName)
    {
        $this->dirName = $dirName;
    }

    /**
     * Getter for @var $this->reportText
     * @return string report text getter
     */
    public function getReportText()
    {
        return $this->reportText;
    }

    /**
     * Getter for @var $this->disPlayResults
     * @return int display results getter
     */
    public function displayResults()
    {
        return $this->disPlayResults;
    }
}
