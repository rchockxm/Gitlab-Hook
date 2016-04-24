<?php
/**
 * GitLib-Hook API
 * Created by Rchockxm
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * Filename: sample.config.php
 */
defined("PHP_FILE_ACCESS") or exit("Access Denied");

// GitLab (Server)
define("GIT_URL", "http://127.0.0.1/");
define("GIT_URL_SSL", "https://127.0.0.1/");
define("GIT_TEST_URL", "http://gitlab.testdomain.com/");
define("GIT_TEST_URL_SSL", "https://gitlab.testdomain.com/");

// Application Dir
define("DIR_APPLICATION", "/var/www/html/Gitlab-Hook/");
define("DIR_APPLICATION_LOGS", DIR_APPLICATION . "logs/");
define("DIR_APPLICATION_WEBSITE", DIR_APPLICATION . "website/");
define("DIR_APPLICATION_WEBSITE_BASH", DIR_APPLICATION_WEBSITE . "bash/");

define("DIR_PRODUCTION_DEPLOY", "/var/www/html/");
define("DIR_DEVELOPER_DEPLOY", "/var/www/html/");

// Production
define("PRODUCTION_SH_DEPLOY", "production_deploy.sh");
define("PRODUCTION_BRANCH", "release");
define("PRODUCTION_BRANCH_REFS", "refs/heads/release");

// Developer (Test)
define("DEVELOPER_SH_DEPLOY", "test_deploy.sh");
define("DEVELOPER_BRANCH", "master");
define("DEVELOPER_BRANCH_REFS", "refs/heads/master");

// Environment Standard Setting
define("ENVIRONMENT_DEVELOPER", true);
?>
