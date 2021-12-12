<?php 

defined('AIN') or exit('NO DICE!');

@ini_set('memory_limit', '-1');

@set_time_limit(0);

// Start the debug
define('AIN_MEM_START', memory_get_usage());

define('AIN_TIME_START', array_sum(explode(' ', microtime())));

if (version_compare(PHP_VERSION, '5.6', '<')) {
    if (function_exists('mb_internal_encoding')) {
        mb_internal_encoding("UTF-8");
    }

    if (function_exists('iconv_set_encoding')) {
        // Not sure if we want to do all of these
        iconv_set_encoding("input_encoding", "UTF-8");
        iconv_set_encoding("output_encoding", "UTF-8");
        iconv_set_encoding("internal_encoding", "UTF-8");
    }
}

if (!isset($_SERVER['HTTP_USER_AGENT'])) {
    $_SERVER['HTTP_USER_AGENT'] = '';
}

if (!defined('AIN_NO_HEADER'))
{
   header('Content-Type: text/html; charset=UTF-8');
}

require_once(AIN_DIR . 'include' . AIN_DS . 'setting' . AIN_DS . 'constant.sett.php');

include(AIN_DIR_CORE . 'vendor/autoload.php');

if (!file_exists(AIN_DIR_CORE . 'vendor/autoload.php')) {
    exit('Dependencies for AIN missing.');
}
// Set error reporting enviroment
error_reporting((AIN_DEBUG ? E_ALL | E_STRICT : 0));

require(AIN_DIR_LIB_CORE . 'ain' . AIN_DS . 'ain.class.php');
require(AIN_DIR_LIB_CORE . 'error' . AIN_DS . 'error.class.php');
require(AIN_DIR_LIB_CORE . 'module' . AIN_DS . 'service.class.php');
require(AIN_DIR_LIB_CORE . 'module' . AIN_DS . 'component.class.php');

if (AIN_DEBUG)
{
	require_once(AIN_DIR_LIB_CORE . 'debug' . AIN_DS . 'debug.class.php');	
}

set_error_handler(array('AIN_Error', 'errorHandler'));

(AIN_DEBUG ? AIN_Debug::start('init') : false);

// Default time to GMT
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('Asia/Tbilisi');

	define('AIN_TIME', time());
}
else 
{
	define('AIN_TIME', strtotime(gmdate("M d Y H:i:s", time())));
}

AIN::getLib('setting')->set();

final class AIN_Plugin
{
	public static function set() {}
	public static function get() {return false;}
}	

if (!defined('AIN_NO_SESSION'))
{
	AIN::getLib('session.handler')->init();
}

AIN::getService('homdom.user')->handleStatus();

function auth($bRedirect = false)
{
	$bIsUser = AIN::getService('homdom.user')->isUser();
	
	if ($bRedirect && !$bIsUser) {
		if (AIN_IS_AJAX || AIN_IS_AJAX_PAGE) {
			return AIN::getLib('ajax')->isUser();
		} else {

			$url = AIN::getLib('url')->getFullUrl();
			
			AIN::getLib('session')->set('redirect', $url);
			
			if( AIN::isAdminPanel() )
				AIN::getLib('url')->send('user.login');
			else
				AIN::getLib('url')->send('login');
		}
	}
	return $bIsUser;   
}
function getUserBy($sVar = null)
{
	return  AIN::getService('homdom.user')->getUserBy($sVar);
}
function _p($sVarName = '', $aParam = [], $sLanguageId = '')
{
    return AIN::getPhrase($sVarName, $aParam, $sLanguageId);
}
function db()
{
    return AIN::getLib('database');
}

function getGroupParam($sName, $bRedirect = false)
{
	if ($bRedirect) {
	 	
		$bPass = (AIN::getService('homdom.user')->get_user_group_params($sName) ? true : false);
		 
		if ( AIN_IS_AJAX && !$bPass )
		{
			if (! auth() )
			{
				// Are we using thickbox?
				if (AIN::getLib('request')->get('tb'))
				{
					AIN::getBlock('user.login-ajax');	
				}
				else 
				{				
					// If we passed an AJAX call we execute it
					if ($sJsCall !== null)
					{
						echo $sJsCall;
					}
					echo "tb_show('" . AIN::getPhrase('user.login_title') . "', \$.ajaxBox('user.login', 'height=250&width=400'));";
				}
			}
			else 
			{
				// Are we using thickbox?
				if (AIN::getLib('request')->get('tb'))
				{
					AIN::getBlock('subscribe.message');
				}
				else 
				{
					// If we passed an AJAX call we execute it
					if ($sJsCall !== null)
					{
						// echo $sJsCall;
					}						
					 echo "/*<script type='text/javascript'>*/window.location.href = '" . AIN::getLib('url')->makeUrl('subscribe.message') . "';/*</script>*/";
				}
			}
			exit;	
		}
		else 
		{
			if (!$bPass)
			{
				if (!  auth() )
				{
					// Create a session so we know where we plan to redirect the user after they login
					AIN::getLib('session')->set('redirect', AIN::getLib('url')->getFullUrl(true));
		
					// Okay thats it lets send them away so they can login
					AIN::getLib('url')->send('user.login');
				}	
				else 
				{				
					AIN::getLib('url')->send('subscribe');
				}
			}
			return true;
		}
	} else {
		return AIN::getService('homdom.user')->get_user_group_params($sName);
	}
}
?>
