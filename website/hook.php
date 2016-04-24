<?php
/**
 * GitLib-Hook API
 * Created by Rchockxm
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * Filename: hook.php
 */
define("RUN_APPLICATION_TYPE", "website");
define("RUN_APPLICATION_CONFIG", "website/config.php");

if (file_exists(RUN_APPLICATION_CONFIG)) {
    @require_once(RUN_APPLICATION_CONFIG);
}

if (!defined("DIR_APPLICATION") 
    || !defined("DIR_APPLICATION_WEBSITE") 
    || !defined("DIR_APPLICATION_WEBSITE_BASH")) {
    
    exit();
}

// Startup
require_once(DIR_APPLICATION . "/website/git.class.php");

$BaseWebsite = new Gitlab\Hook\BaseWebsite();
$BaseWebsite->setEnvironment(ENVIRONMENT_DEVELOPER);
$runRepository = $BaseWebsite->runRepository();
?>
