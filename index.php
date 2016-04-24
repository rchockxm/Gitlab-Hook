<?php
/**
 * GitLib-Hook API
 * Created by Rchockxm
 * Developer: Rchockxm (rchockxm.silver@gmail.com)
 * Filename: index.php
 */
define("PHP_FILE_ACCESS", true);
define("RUN_APPLICATION", "website/hook.php");

if (file_exists(RUN_APPLICATION)) {
    @require_once(RUN_APPLICATION);
}
?>
