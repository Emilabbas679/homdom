<?php
ob_start();

define('AIN', true);

define('AIN_DEBUG', 1);

//define('AIN_NO_TEMPLATE_CACHE', false);

define('AIN_DS', DIRECTORY_SEPARATOR);

define('AIN_DIR', dirname(__FILE__) . AIN_DS);

define('AIN_START_TIME', array_sum(explode(' ', microtime())));

if( isset($_GET['e']) ) define('AIN_DEBUG', true);

require_once(AIN_DIR . 'include' . AIN_DS . 'init.inc.php');

if( isset($_GET['clear']) ) AIN::getLib('cache')->clear();


AIN::run();

 
 
if( isset($_GET['e']) ) e();

ob_end_flush();


?>
