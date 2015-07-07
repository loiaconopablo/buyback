<?php
// change the following paths if necessary
$yii = dirname(__FILE__) . '/../00_private/buyback/vendor/yiisoft/yii/framework/yii.php';
$config = dirname(__FILE__) . '/../00_private/buyback/src/protected/config/main.php';

/**
 * Composer autoloader 
*/
$composerAutoload = realpath(dirname(__FILE__) . '/../00_private/buyback/vendor/autoload.php');

if (file_exists(($composerAutoload))) {
    include_once $composerAutoload;
}
// composer end

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once $yii;
Yii::createWebApplication($config)->run();