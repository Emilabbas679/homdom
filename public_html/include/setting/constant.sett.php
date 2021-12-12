<?php

defined('AIN') or exit('NO DICE!');

define('AIN_NO_PLUGINS', true);

defined('MYSQLI_BOTH') or define('MYSQLI_BOTH', 3);
defined('MYSQLI_NUM') or define('MYSQLI_NUM', 2);
defined('MYSQLI_ASSOC') or define('MYSQLI_ASSOC', 1);
defined('MYSQL_BOTH') or define('MYSQL_BOTH', MYSQLI_BOTH);
defined('MYSQL_NUM') or define('MYSQL_NUM', MYSQLI_NUM);
defined('MYSQL_ASSOC') or define('MYSQL_ASSOC', MYSQLI_ASSOC);

define('AIN_LOG_SQL', true);


if (!defined('AIN_DEBUG')) {
    define('AIN_DEBUG', false);
}
if (!defined('AIN_DEBUG_LEVEL')) {
    define('AIN_DEBUG_LEVEL', 3);
}
define('AIN_SAFE_MODE', ((1 == @ini_get('safe_mode') || 'on' == strtolower(@ini_get('safe_mode'))) ? true : false));

define('AIN_OPEN_BASE_DIR', ((($sBd = @ini_get('open_basedir')) && '/' != $sBd) ? true : false));

// Should the script use PHP's new DateTime and related classes?
define('AIN_USE_DATE_TIME', class_exists('DateTime') && class_exists('DateTimeZone') && method_exists('DateTime', 'settimestamp'));


/*
	Farid Karimov
*/
define('AIN_DIR_CORE',  '/home/every/AIN' . AIN_DS);


// Directory

define('AIN_DIR_INCLUDE', AIN_DIR.'include'.AIN_DS);

define('AIN_DIR_SETTING', AIN_DIR_INCLUDE.'setting'.AIN_DS);

define('AIN_DIR_XML', AIN_DIR_INCLUDE.'xml'.AIN_DS);

define('AIN_DIR_APP', AIN_DIR_INCLUDE.'app'.AIN_DS);

define('AIN_DIR_PLUGIN', AIN_DIR_INCLUDE.'plugin'.AIN_DS);

define('AIN_DIR_LIB', AIN_DIR_INCLUDE.'library'.AIN_DS);

define('AIN_DIR_LIB_CORE', AIN_DIR_LIB.'ain'.AIN_DS);
define('AIN_DIR_THEME', AIN_DIR.'theme'.AIN_DS);

define('AIN_DIR_CRON', AIN_DIR_INCLUDE.'cron'.AIN_DS);

define('AIN_DIR_MODULE', AIN_DIR.'module'.AIN_DS);

define('AIN_DIR_MODULE_COMPONENT', AIN_DS.'component');

define('AIN_DIR_MODULE_SERVICE', 'service');

define('AIN_DIR_MODULE_TPL', AIN_DS.'template');

define('AIN_DIR_MODULE_XML', AIN_DS.'install');

define('AIN_DIR_MODULE_PLUGIN', AIN_DS.'plugin');

define('AIN_DIR_FILE', AIN_DIR.'file'.AIN_DS);

define('AIN_DIR_SETTINGS', AIN_DIR_FILE . 'settings' . AIN_DS);

define('AIN_DIR_CACHE', AIN_DIR_FILE.'cache'.AIN_DS);

define('AIN_DIR_TPL_PLUGIN', AIN_DIR_LIB_CORE.'template'.AIN_DS.'plugin'.AIN_DS);

// URL & Request

define('AIN_GET_METHOD', 'do');

define('AIN_STATIC', 'static/');

define('AIN_STATIC_STYLE', 'static/style/');

define('AIN_INDEX_FILE', 'index.php');

define('AIN_GET_LANGUAGE', 'hl');

define('AIN_GET_LANGUAGE_VALUE', 'az');

// Template

define('AIN_TPL_SUFFIX', '.html.php');

// XML

define('AIN_XML_SUFFIX', '.xml.php');

// Module

define('AIN_MODULE_CORE', 'smart');

define('ADMIN_USER_ID', '1');

define('NORMAL_USER_ID', '2');

define('GUEST_USER_ID', '3');

define('STAFF_USER_ID', '4');

// Is an AJAX routine?
if (!defined('AIN_IS_AJAX')) {
    define('AIN_IS_AJAX', false);
}

if (!defined('AIN_IS_AJAX_PAGE')) {
    define('AIN_IS_AJAX_PAGE', false);
}

// http://www.php.net/manual/en/errorfunc.constants.php PHP 5 >= 5.3.0
if (!defined('E_USER_DEPRECATED')) {
    define('E_USER_DEPRECATED', 16384);
}

/*
 * If problems converting non-latin characters to Unicode
 * Change this to true
 */
define('AIN_UNICODE_JSON', false);

/** Serkan Changes */

define('FPDF_FONTPATH', AIN_DIR_INCLUDE.'library/ain/pdf/font');

/** Serkan Changes */
