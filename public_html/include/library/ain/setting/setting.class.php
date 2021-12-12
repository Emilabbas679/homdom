<?php

defined('AIN') or exit('NO DICE!');

class AIN_Setting
{
	/**
	 * List of all the settings.
	 *
	 * @var array
	 */
	private $_aParams = array();

	public function __construct()
	{	
		$sMessage = 'Oops! AIN is not installed.';

		if (!defined('AIN_INSTALLER') && !file_exists(AIN_DIR_SETTING . 'server.sett.php') )
		{
			AIN::getLib('api')->message($sMessage);
		}
		if (file_exists(AIN_DIR_SETTING . 'server.sett.php'))
		{
			require(AIN_DIR_SETTING . 'server.sett.php');		
		}	
		if (defined('AIN_INSTALLER'))
		{
			$this->_aParams['core']['url_rewrite'] = '2';

			if (($this->_aParams['db']['driver'] == 'mysqli') && !function_exists('mysqli_connect'))
			{
				$this->_aParams['db']['driver'] = 'mysql';
			}			
		}	
	}
	/**
	 * Build the setting cache by getting all the settings from the database
	 * and then caching it. This way we only load it from the database
	 * the one time.
	 *
	 */
	public function set()
	{	
		
	}
	/**
	 * Get a setting and its value.
	 *
	 * @param mixed $mVar STRING name of the setting or ARRAY name of the setting.
	 * @param string $sDef Default value in case the setting cannot be found.
	 * @return nixed Returns the value of the setting, which can be a STRING, ARRAY, BOOL or INT.
	 */
	public function getParam($mVar, $sDef = '')
	{
		if ($mVar == 'core.branding' && AIN::isPackage(array('premium', 'ultimate')))
		{
			return true;
		}
		
		if (is_array($mVar))
		{
			$sParam = (isset($this->_aParams[$mVar[0]][$mVar[1]]) ? $this->_aParams[$mVar[0]][$mVar[1]] : (isset($this->_aDefaults[$mVar[0]][$mVar[1]]) ? $this->_aDefaults[$mVar[0]][$mVar[1]] : AIN_Error::trigger('Missing Param: ' . $mVar[0] . '][' . $mVar[1])));
		}
		else 
		{
			$mVar = explode('.', $mVar );
			
			$sParam = (isset($this->_aParams[$mVar[0]][$mVar[1]]) ? $this->_aParams[$mVar[0]][$mVar[1]] : (isset($this->_aDefaults[$mVar[0]][$mVar[1]]) ? $this->_aDefaults[$mVar[0]][$mVar[1]] : AIN_Error::trigger('Missing Param: ' . $mVar[0].'.'.$mVar[1])));
		
		}
		
		return $sParam;
	}	
	public function setParam($mParam, $mValue = null)
	{
		if (is_string($mParam))
		{
			$mParam = explode('.', $mParam );
			$this->_aParams[$mParam[0]][$mParam[1]] = $mValue;
		}
		else
		{
			foreach ($mParam as $mKey => $mValue)
			{
				$this->_aParams[$mKey] = $mValue;
			}
		}
	}
}
?>