<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Auth extends AIN_Service
{
	private $_sNameCookierefUserId = 'refUserId';
	
	
	private $_sNameCookieUserId = 'user_id';
	private $_sNameCookieHash = 'user_hash';
	private $_aUser = array();
	private $_iOverrideUserId = null;
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		die('Offline Service');
		$this->_sTable = AIN::getT('user');
		
		$iUserId = (int) AIN::getCookie($this->_sNameCookieUserId);
		$sPasswordHash = AIN::getCookie($this->_sNameCookieHash);
		
		if ( $iUserId > 0 )
		{
			$sSelect = 'u.*'; 
			
			$this->_aUser = $this->database()->select($sSelect)
					->from($this->_sTable, 'u')
					->where("u.user_id = '" . $this->database()->escape($iUserId) . "'")
					->execute('getRow', array( 
						'cache' => true,
						'cache_name' => "user-$iUserId"
					));	
					
			if ( isset($this->_aUser['user_id']) )
			{					
				unset($this->_aUser['password'], $this->_aUser['password_salt']);
			}
			else
			{
				$this->_setDefault();
				$this->logout();
			}
		}		
		else
		{
			$this->_setDefault();
		}			
	}
	public function setUserId($iUserId)
	{
		$this->_iOverrideUserId = $iUserId;
	}
	public function login($sLogin, $sPassword, $bRemember = false, $sType = 'email', $bNoPasswordCheck = false)
	{		
		$sSelect = 'user_id, email, user_name, password, password_salt, status_id';
        $sLogin = $this->database()->escape($sLogin);

		$aRow = $this->database()->select($sSelect)
			->from($this->_sTable)
			->where(($sType == 'both' ? "email = '" . $sLogin . "' OR user_name = '" . $sLogin . "'" : ($sType == 'email' ? "email" : "user_name") . " = '" . $sLogin . "'"))
			->execute('getRow');
			
		if (!isset($aRow['user_name']))
		{
			AIN_Error::set(AIN::getPhrase('user.invalid_login_id'));

			return array(false, $aRow);
		}
		else
		{
			if ( !$bNoPasswordCheck && (AIN::getLib('hash')->setHash($sPassword, $aRow['password_salt']) != $aRow['password']))
			{
				AIN_Error::set(AIN::getPhrase('user.invalid_password'));
				
				AIN::getService('user.log')->userLog( array( 'user_id' =>  $aRow['user_id'], 'type_id' =>  'login_failed' ) );
				
				return array(false, $aRow);
			}
		}				
		if ( AIN_Error::isPassed() )
		{						
			$sPasswordHash = AIN::getLib('hash')->setRandomHash(AIN::getLib('hash')->setHash($aRow['password'], $aRow['password_salt']));
			$iTime = ($bRemember ? (AIN_TIME + 3600 * 24 * 365) : 0);
			
			AIN::setCookie($this->_sNameCookieUserId, $aRow['user_id'], $iTime, (AIN::getParam('core.force_secure_site') ? true : false));
			AIN::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime, (AIN::getParam('core.force_secure_site') ? true : false));
			
			$this->database()->update($this->_sTable, array('last_login' => AIN_TIME), 'user_id = ' . $aRow['user_id']);	
			
			AIN::getService('user.log')->userLog( array( 'user_id' =>  $aRow['user_id'], 'type_id' =>  'login_success' ) );
				
			return array(true, $aRow);
		}

		return array(false, $aRow);
	}
	private function _setDefault()
	{		
		$this->_aUser = array(
			'user_id' => 0,
			'user_group_id' => GUEST_USER_ID,
		);
	}	
	public function logout()
	{
		AIN::setCookie($this->_sNameCookieUserId, 0, -1, false);
		AIN::setCookie($this->_sNameCookieHash, 0, -1, false );
	}
	
	public function getUserBy($sVar = null)
	{
		if ($sVar === null && isset($this->_aUser['user_id']) && $this->_aUser['user_id'] > 0)
		{
			return $this->_aUser;
		}		

		if (isset($this->_aUser[$sVar]))
		{
			return $this->_aUser[$sVar];
		}
		return false;
	}		
	public function getUserId()
	{
		if ($this->_iOverrideUserId !== null)
		{
			return $this->_iOverrideUserId;
		}
		
		return (int) $this->_aUser['user_id'];
	}
	
	public function isUser()
	{
		return (($this->_aUser['user_id'] ) ? true : false);
	}
	
	public function handleStatus()
	{		
		// Hazirlanir 	
		return;
	}
}
?>