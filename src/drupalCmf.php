<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 14.11.2018
 * Time: 1:59
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


class drupalCmf extends baseCms
{
    public function __construct($dirName, $commentStart = '# ', $commentEnd = '')
    {
        $this->dirName = $dirName;
        $this->configFile = $this->dirName . DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'settings.php';
        $this->commentStart = $commentStart;
        $this->commentEnd = $commentEnd;
        $this->setDefaultDbsValue();
    }

    public function detectCMS()
    {
        include_once $this->configFile;
        $this->reportText .= $this->commentStart . ' Loaded default config file ' . $this->configFile . ' ' . $this->commentEnd . PHP_EOL;
        if (isset($db_url)) {
            // Drupal 6 ?
            $this->reportText .= $this->commentStart . ' Detected Drupal 6 ' . $this->commentEnd . PHP_EOL;
            $ap1 = parse_url($db_url);
            $this->dbs[0]['host'] = $ap1['host'];
            $this->dbs[0]['name'] = substr($ap1['path'], 1);
            $this->dbs[0]['user'] = $ap1['user'];
            $this->dbs[0]['pass'] = $ap1['pass'];
            if (strlen($this->dbs[0]['name']) > 0
                && strlen($this->dbs[0]['user']) > 0
            ) {
                $this->disPlayResults = 1;
            }
        } else {
            if (isset($databases)) {
                // Drupal 7+ ?
                $this->reportText .= $this->commentStart . ' Detected Drupal 7+ ' . ' ' . $this->commentEnd . PHP_EOL;
                if (count($databases > 0)) {
                    $i = 0;
                    foreach ($databases as $aDb) {
                        $this->dbs[$i]['host'] = $aDb['default']['host'];
                        $this->dbs[$i]['name'] = $aDb['default']['database'];
                        $this->dbs[$i]['user'] = $aDb['default']['username'];
                        $this->dbs[$i]['pass'] = $aDb['default']['password'];
                        ++ $i;
                    }
                } else {
                    $this->dbs[0]['host'] = $databases['default']['default']['host'];
                    $this->dbs[0]['name'] = $databases['default']['default']['database'];
                    $this->dbs[0]['user'] = $databases['default']['default']['username'];
                    $this->dbs[0]['pass'] = $databases['default']['default']['password'];
                }
                $multisiteConfig = $this->dirName . DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . 'sites.php';
                if (file_exists($multisiteConfig)) {
                    include_once $multisiteConfig;
                    $this->reportText .= $this->commentStart . ' Loaded Drupal multisite config file ' . $multisiteConfig . ' ' . $this->commentEnd . PHP_EOL;
                    if (isset($sites) && is_array($sites) && (count($sites) > 0)) {
                        $j = 0;
                        foreach ($sites as $domain => $configFolder) {
                            $configFile = $this->dirName . DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . $configFolder . DIRECTORY_SEPARATOR . 'settings.php';
                            if (file_exists($configFile)) {
                                include_once $configFile;
                                $this->reportText .= $this->commentStart . ' Loaded config file ' . $configFile . ' for (sub)domain ' . $domain . ' ' . $this->commentEnd . PHP_EOL;
                                if (count($databases > 0)) {
                                    foreach ($databases as $aDb) {
                                        if (($this->dbs[0]['host'] !== $aDb['default']['host'])
                                            && ($this->dbs[0]['name'] !== $aDb['default']['database'])
                                            && ($this->dbs[0]['user'] !== $aDb['default']['username'])
                                            && ($this->dbs[0]['pass'] !== $aDb['default']['password'])
                                        ) {
                                            ++ $j;
                                            $this->dbs[$j]['host'] = $aDb['default']['host'];
                                            $this->dbs[$j]['name'] = $aDb['default']['database'];
                                            $this->dbs[$j]['user'] = $aDb['default']['username'];
                                            $this->dbs[$j]['pass'] = $aDb['default']['password'];
                                        } else {
                                            $this->reportText .= $this->commentStart . ' Skipped db settings because the same already exists. ' . $this->commentEnd . PHP_EOL;
                                        }
                                    }
                                } else {
                                    $this->reportText .= $this->commentStart . ' Databases: ' . var_export($databases, 1) . ' ' . $this->commentEnd . PHP_EOL;
                                }
                            }
                        }
                    } else {
                        $this->reportText .= $this->commentStart . ' Problems with reading multisite configuration ' . $this->commentEnd . PHP_EOL;
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
