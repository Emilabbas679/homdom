<?php

defined('AIN') or exit('NO DICE!');

class AIN
{
	/**
 	* Product Version : major.minor.maintenance [alphaX, betaX or rcX]
 	*/
	const VERSION = '2.0.0';
	
	/**
	 * Product Code Name
	 * 
	 */	
	const CODE_NAME = 'FaridKarimov';
	
	/**
	 * Browser agent used with API curl requests.
	 *
	 */
	const BROWSER_AGENT = 'Azerbaijan International Network';
	
	/**
	 * Product build number.
	 *
	 */
	const PRODUCT_BUILD = '1';
	
	/**
	 * AIN API server.
	 *
	 */
	const AIN_API = '';
	
	/**
	 * AIN package ID.
	 *
	 */
	const AIN_PACKAGE = 'ultimate';
	
	/**
	 * ARRAY of objects initiated. Used to keep a static history
	 * so we don't call the same class more then once.
	 *
	 * @var unknown_type
	 */
	private static $_aObject = array();
	
	/**
	 * ARRAY of libraries being loaded.
	 *
	 * @var array
	 */
	private static $_aLibs = array();
	
	/**
	 * ARRAY of custom pages the site admins have created.
	 *
	 * @var array
	 */
	private static $_aPages = array();
	
	/**
	 * Used to keep a static variable to see if we are within the AdminCP.
	 *
	 * @var bool
	 */
	private static $_bIsAdminCp = false;	
	
	/**
	 * History of any logs we save for debug purposes.
	 *
	 * @var array
	 */
	private static $_aLogs = array();	
	
	/**
	 * Get the current AIN version.
	 *
	 * @return string
	 */
	public static function getVersion()
	{
		return self::VERSION;
	}
	
	/**
	 * Get the current AIN version ID.
	 *
	 * @return int
	 */
	public static function getId()
	{
		return self::getVersion();
	}
	
	/**
	 * Get the products code name.
	 *
	 * @return string
	 */
	public static function getCodeName()
	{
		return self::CODE_NAME;
	}
	
	/**
	 * Get the products build number.
	 *
	 * @return int
	 */
	public static function getBuild()
	{
		return self::PRODUCT_BUILD;
	}
	
	/**
	 * Get the clean numerical value of the AIN version.
	 *
	 * @return int
	 */
	public static function getCleanVersion()
	{
		return str_replace('.', '', self::VERSION);
	}
	
	/**
	 * Check if a feature can be used based on the package the client
	 * has installed.
	 * 
	 * Example (STRING):
	 * <code>
	 * if (AIN::isPackage('1') { }
	 * </code>
	 * 
	 * Example (ARRAY):
	 * <code>
	 * if (AIN::isPackage(array('1', '2')) { }
	 * </code>
	 *
	 * @param mixed $mPackage STRING can be used to pass the package ID, or an ARRAY to pass multipl packages.
	 * @return unknown
	 */
	public static function isPackage($mPackage)
	{
		if (self::AIN_PACKAGE == '[AIN_PACKAGE_NAME]')
		{
			return false;
		}
		
		if (!is_array($mPackage))
		{
			$mPackage = array($mPackage);
		}
		
		return (in_array(self::AIN_PACKAGE, $mPackage) ? true : false);
	}
	
	/**
	 * Provide "powered by" link.
	 *
	 * @param bool $bLink TRUE to include a link to AIN.
	 * @param bool $bVersion TRUE to include the version being used.
	 * @return string Powered by AIN string returned.
	 */
	public static function link($bLink = true, $bVersion = true)
	{
		if (AIN::getParam('core.branding'))
		{
			return '';
		}
		
		return 'Powered By AIN' . ($bVersion ? ' Version ' . AIN::getVersion() : '');
	}
	/**
	 * Gets and creates an object for a class.
	 *
	 * @param string $sClass Class name.
	 * @param array $aParams Params to pass to the class.
	 * @return object Object created will be returned.
	 */
	public static function &getObject($sClass, $aParams = array())
	{		
		$sHash = md5($sClass . serialize($aParams));
		
		if (isset(self::$_aObject[$sHash]))
		{
			return self::$_aObject[$sHash];
		}	

		(AIN_DEBUG ? AIN_Debug::start('object') : false);
		
		$sClass = str_replace(array('.', '-'), '_', $sClass);		
		
		if (!class_exists($sClass))
		{
			AIN_Error::trigger('Unable to call class: ' . $sClass, E_USER_ERROR);
		}		

		if ($aParams)
		{
			self::$_aObject[$sHash] = new $sClass($aParams);
		}
		else 
		{		
			self::$_aObject[$sHash] = new $sClass();
		}

		(AIN_DEBUG ? AIN_Debug::end('object', array('name' => $sClass)) : false);
		
		if (method_exists(self::$_aObject[$sHash], 'getInstance'))
		{
			return self::$_aObject[$sHash]->getInstance();
		}				
		
		return self::$_aObject[$sHash];
	}
	/**
	 * Fine and load a library class and make sure it exists.
	 *
	 * @param string $sClass Library class name.
	 * @return bool TRUE if library has loaded, FALSE if not.
	 */
	public static function getLibClass($sClass)
	{
		( class_exists('AIN_Plugin') && ($sPlugin = AIN_Plugin::get('library_ain_getlibclass_0')) ? eval($sPlugin) : false);
		if (isset(self::$_aLibs[$sClass]))
		{
			return true;
		}

		self::$_aLibs[$sClass] = md5($sClass);		
		
		$sClass = str_replace('.', AIN_DS, $sClass);
		$sFile = AIN_DIR_LIB . $sClass . '.class.php';
		
		if (file_exists($sFile))
		{			
			require_once($sFile);
			return true;
		}		
		
		$aParts = explode(AIN_DS, $sClass);		
		if (isset($aParts[1]))
		{
			$sSubClassFile = AIN_DIR_LIB . $sClass . AIN_DS . $aParts[1] . '.class.php';			
			if (file_exists($sSubClassFile))
			{
				require_once($sSubClassFile);
				return true;
			}
		}		
	
        ( class_exists('AIN_Plugin') &&  ($sPlugin = AIN_Plugin::get('library_ain_getlibclass_1')) ? eval($sPlugin) : false);if(isset($mPluginReturn)){return $mPluginReturn;}
		
		AIN_Error::trigger('Unable to load class: ' . $sClass, E_USER_ERROR);
		
		return false;
	}
	/**
	 * Get a AIN library. This includes the class file and creates the object for you.
	 * 
	 * Example usage:
	 * <code>
	 * AIN::getLib('url')->makeUrl('test');
	 * </code>
	 * In the example we called the URL library found in the folder: include/library/AIN/url/url.class.php
	 * then created an object for it so we could directly call the method "makeUrl".
	 *
	 * @param string $sClass Library class name.
	 * @param array $aParams ARRAY of params you can pass to the library.
	 * @return object Object of the library class is returned.
	 */
	public static function &getLib($sClass, $aParams = array())
	{	
		(class_exists('AIN_Plugin') && ($sPlugin = AIN_Plugin::get('library_ain_getlib_0')) ? eval($sPlugin) : false);
		
		if ( (substr($sClass, 0, 7) != 'ain.') )
		{
			$sClass = 'ain.' . $sClass;
		}
		
		$sHash = md5($sClass . serialize($aParams));
		
		if (isset(self::$_aObject[$sHash]))
		{	
			return self::$_aObject[$sHash];
		}		
		
		AIN::getLibClass($sClass);		

		//$sClass = str_replace('ain.ain.', 'ain.', $sClass);		

		self::$_aObject[$sHash] = AIN::getObject($sClass, $aParams);
		
		return self::$_aObject[$sHash];
	}
	/**
	 * Returns the token name for forms
	 */
	public static function getTokenName()
	{
		return 'core';	
	}
	
	/**
	 * Builds a database table prefix.
	 *
	 * @param string $sTable Database table name.
	 * @return string Returns the table name with the clients prefix.
	 */
	public static function getT($sTable)
	{
        return AIN::getParam(array('db', 'prefix')) . $sTable;
	}
	
	/**
	 * @see AIN_Setting::getParam()
	 * @param string $sVar
	 * @return mixed
	 */
	public static function getParam($sVar)
	{
		return AIN::getLib('setting')->getParam($sVar);
	}
	/**
	 * @see AIN_Module::getService()
	 * @param string $sClass
	 * @param array $aParams
	 * @return object
	 */
	public static function getService($sClass, $aParams = array())
	{
		return AIN::getLib('module')->getService($sClass, $aParams);
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function isMobile()
	{
		return false;
	}		

	
	
	
	
	
	
	/**
	 * Add a public message which can be used later on to display information to a user.
	 * Message gets stored in a $_SESSION so the message can be viewed after page reload in case
	 * it is used with a HTML form.
	 *
	 * @see AIN_Session::set()
	 *
	 * @param string $sMsg Message we plan to display to the user
	 */
	public static function addMessage($sMsg)
	{
		AIN::getLib('session')->set('message', $sMsg);
	}

	/**
	 * Get the public message we setup earlier
	 *
	 * @see AIN_Session::get()
	 * @return string|void Return the public message, or return nothing if no public message is set
	 */
	public static function getMessage()
	{
		return AIN::getLib('session')->get('message');
	}

	/**
	 * Clear the public message we set earlier
	 *
	 * @see AIN_Session::remove()
	 */
	public static function clearMessage()
	{
		AIN::getLib('session')->remove('message');
	}
	
	
	
	/**
	 * Set a cookie with PHP setcookie()
	 *
	 * @see setcookie()
	 *
	 * @param string $sName   The name of the cookie.
	 * @param string $sValue  The value of the cookie.
	 * @param int    $iExpire The time the cookie expires. This is a Unix timestamp so is in number of seconds since the epoch.
	 */
	public static function setCookie($sName, $sValue, $iExpire = 0, $bSecure = false, $bHttpOnly = true)
	{
		$sName = AIN::getParam('core.session_prefix') . $sName;
       
		if (($iExpire - AIN_TIME) > 0){
            $iRealExpire = $iExpire;
        } else {
            $iRealExpire = (($iExpire <= 0) ? null : (AIN_TIME + (60 * 60 * 24 * $iExpire)));
        }
		
		
		
		if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
			setcookie($sName, $sValue, $iRealExpire, AIN::getParam('core.cookie_path'), AIN::getParam('core.cookie_domain'), $bSecure, $bHttpOnly);
		} else {
			setcookie($sName, $sValue, $iRealExpire, AIN::getParam('core.cookie_path'), AIN::getParam('core.cookie_domain'), $bSecure);
		}
	}

	/**
	 * Gets a cookie set by the method self::setCookie().
	 *
	 * @param string $sName Name of the cookie.
	 *
	 * @return string Value of the cookie.
	 */
	public static function getCookie($sName)
	{
		$sName = AIN::getParam('core.session_prefix') . $sName;

		return (isset($_COOKIE[ $sName ]) ? $_COOKIE[ $sName ] : '');
	}

    public static function removeCookie($sName){
        $sName = AIN::getParam('core.session_prefix') . $sName;	
		
        if (isset($_COOKIE[$sName])){
            unset($_COOKIE[$sName]);
        }
    }
	
	
	
	
	/**
	 * @see AIN_Module::callback()
	 *
	 * @param string $sCall
	 *
	 * @return mixed
	 */
	public static function callback($sCall)
	{
		if (func_num_args() > 1) {
			$aParams = func_get_args();

			return AIN_Module::instance()->callback($sCall, $aParams);
		}

		return AIN_Module::instance()->callback($sCall);
	}
	/**
	 * @see AIN_Module::getComponent()
	 *
	 * @param string $sClass  Class name.
	 * @param array  $aParams ARRAY of params you can pass to the component.
	 * @param string $sType   Type of component (block or controller).
	 *
	 * @return object We return the object of the component class.
	 */
	public static function getComponent($sClass, $aParams = [], $sType = 'block', $bTemplateParams = false)
	{
		return AIN::getLib('module')->getComponent($sClass, $aParams, $sType, $bTemplateParams);
	}
	public static function getBlock($sClass, $aParams = [], $bTemplateParams = false)
	{
		return AIN::getLib('module')->getComponent($sClass, $aParams, 'block', $bTemplateParams);
	}
	
	
	
	
	
	
	
	public static function run()
	{
		$oTpl = AIN::getLib('template');		
		$oReq = AIN::getLib('request');		
		$oModule = AIN::getLib('module');	
		$aLocale = AIN::getLib('locale')->getLang();
		
		$oModule->setController();		
		
		if( AIN::getParam('core.json') )
		{
			header("Content-type:application/json");
			echo json_encode($oModule);
			die();
		}					
		
		if ($oReq->segment(1) == '_ajax') {
			$_SERVER['HTTP_ORIGIN'] = $_SERVER['HTTP_ORIGIN'] ?? 'homdom.az';
			header("Access-Control-Allow-Origin: $_SERVER[HTTP_ORIGIN]"); 
			$oAjax = AIN::getLib('ajax');
			$oAjax->process();
			echo $oAjax->getData();
			exit;
		}

		$oModule->getController();			

		if (! AIN_IS_AJAX_PAGE && ( $sHeaderFile = $oTpl->getHeaderFile()) ) {
			require_once($sHeaderFile);
		}			
		
		$oTpl->assign([
				'aGlobalUser'   => (AIN::isUser() ? AIN::getUserBy(null) : []),
				'aErrors'          => (AIN_Error::getDisplay() ? AIN_Error::get() : []),
				'sPublicMessage'   => AIN::getMessage(),					
				'sGlobalUserFullName'     => (AIN::isUser() ? AIN::getUserBy('full_name') : null),
				'sFullControllerName'     => str_replace(['.', '/'], '_', AIN_Module::instance()->getFullControllerName()),
				'sLocaleCode'      => isset($aLocale['language_id']) ? $aLocale['language_id'] : 'az',
			]
		);	
		
		if (!AIN_IS_AJAX_PAGE && $oTpl->sDisplayLayout)
		{			
			$oTpl->getLayout($oTpl->sDisplayLayout);
		}	
		
		AIN::clearMessage();			
	}	
	public static function isAdminPanel()
	{
		return (self::$_bIsAdminCp ? true : false);
	}
	public static function isUser($bRedirect = false)
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
	public static function getIp($bReturnNum = false)
	{
		return AIN::getLib('request')->getIp($bReturnNum);
	}
	public static function getUserId()
	{
		return AIN::getService('homdom.user')->getUserId();
	}
	public static function getUserBy($sVar = null)
	{
		return AIN::getService('homdom.user')->getUserBy($sVar);
	}	
	public static function getPhrase($sParam, $aParams = [], $bNoDebug = false, $sDefault = null, $sLang = '')
	{
		return AIN::getLib('locale')->getPhrase($sParam, $aParams, $bNoDebug, $sDefault, $sLang);
	}
	
	
	
	
	
	
	
	
	public static function getTimeZone($bDst = false)
	{
		return AIN::getLib('date')->getTimeZone($bDst);
	}
	public static function getTime($sStamp = null, $iTime = AIN_TIME, $bTimeZone = true)
	{
		static $sUserOffSet;

		if ($bTimeZone) {
			if (!$sUserOffSet) {
				$sUserOffSet = AIN::getTimeZone();
			}
			if (!preg_match('/z[0-9]+/i', $sUserOffSet, $aMatch)) {
				// try to find it in the cache
				$aTZ = AIN::getService('core')->getTimeZones();
				$sTz = array_search($sUserOffSet, $aTZ);
				if ($sTz !== false) {
					$sUserOffSet = $sTz;
				}
			}
			if (substr($sUserOffSet, 0, 1) == 'z' && AIN_USE_DATE_TIME) {
				// we are using DateTime
				// get the offset to use based on the time zone index code
				if (!isset($aTZ)) {
					$aTZ = AIN::getService('core')->getTimeZones();
				}
				if (isset($aTZ[ $sUserOffSet ])) {
					$oTZ = new DateTimeZone($aTZ[ $sUserOffSet ]);
					$oDateTime = new DateTime(null, $oTZ);
					$oDateTime->setTimestamp($iTime);
					$sUserOffSet = $aTZ[ $sUserOffSet ];
					if ($sStamp !== null) {
						$iNewTime = $oDateTime->format($sStamp);
						$bSet = true;
					}
				}
			}

			if ($sStamp === null) {
				return (!empty($sUserOffSet) ? (substr($sUserOffSet, 0, 1) == '-' ? ($iTime - (substr($sUserOffSet, 1) * 3600)) : ($sUserOffSet * 3600) + $iTime) : $iTime);
			} elseif (!isset($bSet)) {
				$iNewTime = (!empty($sUserOffSet) ? date($sStamp, (substr($sUserOffSet, 0, 1) == '-' ? ($iTime - (substr($sUserOffSet, 1) * 3600)) : ($sUserOffSet * 3600) + $iTime)) : date($sStamp, $iTime));

			}
		} else {
			$iNewTime = date($sStamp, $iTime);
		}

		$aFind = [
				'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
				'Sunday',
				'January',
				'February',
				'March',
				'April',
				'May',
				'June',
				'July',
				'August',
				'September',
				'October',
				'November',
				'December'
		];

		$aReplace = [
				AIN::getPhrase('core.monday'),
				AIN::getPhrase('core.tuesday'),
				AIN::getPhrase('core.wednesday'),
				AIN::getPhrase('core.thursday'),
				AIN::getPhrase('core.friday'),
				AIN::getPhrase('core.saturday'),
				AIN::getPhrase('core.sunday'),
				
				AIN::getPhrase('core.january'),
				AIN::getPhrase('core.february'),
				AIN::getPhrase('core.march'),
				AIN::getPhrase('core.april'),
				AIN::getPhrase('core.may'),
				AIN::getPhrase('core.june'),
				AIN::getPhrase('core.july'),
				AIN::getPhrase('core.august'),
				AIN::getPhrase('core.september'),
				AIN::getPhrase('core.october'),
				AIN::getPhrase('core.november'),
				AIN::getPhrase('core.december')
		];
		$iNewTime = str_replace($aFind, $aReplace, $iNewTime);
		$iNewTime = str_replace('PM', AIN::getPhrase('core.pm'), $iNewTime);
		$iNewTime = str_replace('AM', AIN::getPhrase('core.am'), $iNewTime);

		return $iNewTime;
	}
	public static function getUserParam($sName, $bRedirect = false, $sJsCall = null)
	{
		if (defined('AIN_INSTALLER')) {
			return true;
		}
		
		$bPass = (AIN::getService('user.group.setting')->getParam($sName) ? true : false);
		
		if ($bRedirect) {
			if (AIN_IS_AJAX && !$bPass) {
				if (!AIN::isUser()) {
					// Are we using thickbox?
					if (AIN_Request::instance()->get('tb')) {
						AIN::getBlock('user.login-ajax');
					} else {
						// If we passed an AJAX call we execute it
						if ($sJsCall !== null) {
							echo $sJsCall;
						}
						echo "tb_show('" . AIN::getPhrase('user.login_title') . "', \$.ajaxBox('user.login', 'height=250&width=400'));";
					}
				} else {
					// Are we using thickbox?
					if (AIN_Request::instance()->get('tb')) {
						AIN::getBlock('user.subscribe');
					} else {
						// If we passed an AJAX call we execute it
						if ($sJsCall !== null) {
							// echo $sJsCall;
						}
						echo "/*<script type='text/javascript'>*/window.location.href = '" . AIN_Url::instance()->makeUrl('user.subscribe.message') . "';/*</script>*/";
					}
				}
				exit;
			} else {
				if (!$bPass) {
					if (!AIN::isUser()) {
						// Create a session so we know where we plan to redirect the user after they login
						AIN::getLib('session')->set('redirect', AIN_Url::instance()->getFullUrl(true));

						// Okay thats it lets send them away so they can login
						AIN_Url::instance()->send('user.login');
					} else {
						AIN_Url::instance()->send('user.subscribe');
					}
				}

				return true;
			}
		} else {
			return AIN::getService('user.group.setting')->getParam($sName);
		}
	}	
	/**
	 * @see AIN_Module::massCallback()
	 *
	 * @param string $sMethod
	 *
	 * @return mixed
	 */
	public static function massCallback($sMethod)
	{
		if (func_num_args() > 1) {
			$aParams = func_get_args();

			return AIN_Module::instance()->massCallback($sMethod, $aParams);
		}

		return AIN_Module::instance()->massCallback($sMethod);
	}
    public static function sendApi($action = 'get_advert', $parameters = [])
    {
//        $url = 'http://49.12.92.130/api.php';
//        $url = 'https://every.smartbee.az/api.php';
        $url = 'https://every.ainsyndication.com/api.php';
		$data = [];
        $data['action'] = $action;		
        $data['parameters'] = $parameters;			
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
        $data_string = json_encode($data, JSON_NUMERIC_CHECK);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);  // Seems like good practice
        return json_decode($result, true);
    }
}
?>