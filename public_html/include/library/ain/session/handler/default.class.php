<?php

defined('AIN') or exit('NO DICE!');

class AIN_Session_Handler_Default
{	
	/**
	 * Loads session handler. All we do here is start a session.
	 *
	 */
	public function init()
	{
		if(!isset($_SESSION))
		{
			session_start();	
		}
	}
}

?>