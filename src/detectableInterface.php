<?php
/**
 * Created by PhpStorm.
 * User: Taras
 * Date: 13.11.2018
 * Time: 22:03
 *
 * @author Taras Shkodenko <taras@shkodenko.com>
 */

namespace getMysqlCms;


/**
 * Interface detectableInterface
 * @package getMysqlCms
 */
interface detectableInterface {
    function detectCMS();
    function detectSetVersion();
}