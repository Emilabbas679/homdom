<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Verify_Verify extends AIN_Service
{	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('user');
	}

	/**
	 * @param string $sEmail
	 * @return string
	 */
	public function getVerifyHashByEmail($sEmail)
	{
		if(!$sEmail)
			return false;

		return $this->database()
		->select('hash_code')
		->from(AIN::getT('user_verify'))
		->where('email=\''. $this->database()->escape($sEmail). '\'')
		->execute('getSlaveField');
	}

	/**
	 * Generates the unique hash to be used when verifying email addresses
	 * @param array $aUser
	 * @return String 50~52 chars
	 */
	public function getVerifyHash($aUser)
	{
		return AIN::getLib('hash')->setRandomHash($aUser['user_id'] . $aUser['email'] . $aUser['password'] . AIN::getParam('core.salt'));
	}
	public function __call($sMethod, $aArguments)
	{

		if ($sPlugin = AIN_Plugin::get('user.service_activity__call'))
		{
			eval($sPlugin);
            return null;
		}

		AIN_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
	}
}
?>