<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Callback extends AIN_Service
{
	public function  __construct()
	{
		$this->_sTable = AIN::getT('user');
	}
	/**
	 * Action to take when user cancelled their account
	 * @param int $iUser
	 */
	public function onDeleteUser($iUser)
	{
		$this->database()->delete(AIN::getT('user'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(AIN::getT('user_password_request'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(AIN::getT('user_social_fbconnect'), 'user_id = ' . (int)$iUser);
		
		
		
		$this->database()->delete(AIN::getT('user_purses'), 'user_id = ' . (int)$iUser);
		$this->database()->delete(AIN::getT('user_purses_log'), 'user_id = ' . (int)$iUser);
	}
}
?>	