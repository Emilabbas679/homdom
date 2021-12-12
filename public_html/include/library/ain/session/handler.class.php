<?php

defined('AIN') or exit('NO DICE!');

class AIN_Session_Handler
{
	/**
	 * Session object.
	 *
	 * @var object
	 */
	private $_oObject = null;

	/**
	 * Class constructor which loads the session hanlder we should use.
	 *
	 * @return object
	 */
	public function __construct()
	{
		if (!$this->_oObject)
		{
			$sStorage = 'session.handler.default';		
			
				if (defined('AIN_IS_AJAX') && AIN_IS_AJAX)
				{
					$sStorage = 'session.handler.file';			
				}
				else
				{
					if (AIN::getParam(array('balancer', 'enabled')))
					{
						$sStorage = 'session.handler.memcache';
					}
				}
			
			$this->_oObject = AIN::getLib($sStorage);
		}
		return $this->_oObject;
	}	
	
	/**
	 * Get session object.
	 *
	 * @return Returns the session object we loaded with the class constructor.
	 */
	public function &getInstance()
	{
		return $this->_oObject;
	}	
}

?>