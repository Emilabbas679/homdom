<?php

ob_start();

define('AIN', true);

define('AIN_DEBUG', true);

define('AIN_IS_AJAX', false);

define('AIN_NO_SESSION', true);

define('AIN_DEBUG_LEVEL', 3);

define('AIN_DS', DIRECTORY_SEPARATOR);

define('AIN_DIR', dirname(dirname(dirname(__FILE__))).AIN_DS);

/**
 * Do not run
 */
define('AIN_NO_RUN', true);

define('AIN_CRON', true);

require_once AIN_DIR.'include'.AIN_DS.'init.inc.php';

AIN::getService('homdom.helpers')->index( ['nocache' => true ] );

$time = (microtime(true) - AIN_TIME_START);
$message = 'Process ' . 1 . ' job(s) in ' . $time;
echo $message;


?>