<?php

/**
 * Detect popular CMS MySQL database settings and output .my.cnf
 *
 * PHP version 5.4+
 *
 * @category PHP_CLI_Scripts
 * @package  Get Сreate my.cnf MySQL configuration file
 * @author   Taras Shkodenko <taras@shkodenko.com>
 * @license  GNU GENERAL PUBLIC LICENSE Version 2
 * @link     http://www.shkodenko.com/
 */

namespace getMysqlCms;


require_once 'inc' . DIRECTORY_SEPARATOR . 'init.php';


Util::setScriptName(__FILE__);

if (isset($argv[1])) {
    if (strlen($argv[1]) > 0) {
        $dm = new detectManager($argv[1], '/*', '*/');
    } else {
        Util::printUsage();
        return 2;
    }
} else {
    Util::printUsage();
    return 3;
}

reportResults::init($dm->getDbs(), $dm->getReportText(), $dm->displayResults());
echo reportResults::getReport(reportResults::CREATE);