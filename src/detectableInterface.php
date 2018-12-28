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
 * every class which implements this interface
 * should have such methods
 *
 * @package getMysqlCms
 */
interface detectableInterface {
    /**
     * @return mixed
     */
    function detectCMS();

    /**
     * @return mixed
     */
    function detectSetVersion();
}
