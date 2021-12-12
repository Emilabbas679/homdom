<?php


defined('AIN') or exit('NO DICE!');

class AIN_Session_Storage_Session
{
	/**
	 * Prefix of the session name.
	 *
	 * @var unknown_type
	 */	
	private $_sPrefix = 'AIN';
	
	/**
	 * Not in use.
	 * 
	 * @deprecated 2.0.5
	 * @var array
	 */
	private $_aCookie = array();
	
	/**
	 * Class constructor. Gets the new prefix from the global settings.
	 *
	 */	
	public function __construct()
	{
		$this->_sPrefix = AIN::getParam('core.session_prefix');
	}
		
	/**
	 * Sets a session.
	 *
	 * @see AIN::setCookie()
	 * @param string $sName Name of the session.
	 * @param string $sValue Value of the session.
	 */	
	public function set($sName, $sValue)
	{
		$_SESSION[$this->_sPrefix][$sName] = $sValue;
	}
	
	/**
	 * Gets a session.
	 *
	 * @param string $sName Name of the session.
	 * @return mixed Session exists we return its value, otherwise we return FALSE.
	 */	
	public function get($sName)
	{		
		if (isset($_SESSION[$this->_sPrefix][$sName]))
		{
			return (empty($_SESSION[$this->_sPrefix][$sName]) ? true : $_SESSION[$this->_sPrefix][$sName]);
		}

		return false;		
	}
	
	/**
	 * Removes a session.
	 *
	 * @param mixed $mName STRING name of session, ARRAY of sessions.
	 */	
	public function remove($mName)
	{
		if (!is_array($mName))
		{
			$mName = array($mName);
		}
		(($sPlugin = AIN_Plugin::get('session_remove__start')) ? eval($sPlugin) : false);
		foreach ($mName as $sName)
		{			
			unset($_SESSION[$this->_sPrefix][$sName]);			
		}
	}
	
	/**
	 * Set an ARRAY session.
	 *
	 * @param string $sName Name of session.
	 * @param string $sValue Group of session.
	 * @param string $sActualValue Value of the session.
	 */	
	public function setArray($sName, $sValue, $sActualValue)
	{
		$_SESSION[$this->_sPrefix][$sName]['value_' . $sValue] = $sActualValue;
	}
	
	/**
	 * Get a session ARRAY.
	 *
	 * @param string $sName Name of the session.
	 * @param string $sValue Name of the group session.
	 * @return mixed Session exists we return its value, otherwise we return FALSE.
	 */	
	public function getArray($sName, $sValue)
	{		
		if (isset($_SESSION[$this->_sPrefix][$sName]['value_' . $sValue]))
		{
			return $_SESSION[$this->_sPrefix][$sName]['value_' . $sValue];
		}
		
		return false;
	}	
}

?>