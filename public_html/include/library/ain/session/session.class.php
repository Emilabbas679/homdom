<?php

defined('AIN') or exit('NO DICE!');

class AIN_Session
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
			$sStorage = 'session.storage.session';

			if (AIN::getParam('core.url_rewrite') == 3)
			{
				$sStorage = 'session.storage.cookie';
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