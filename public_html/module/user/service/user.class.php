<?php


defined('AIN') or exit('NO DICE!');

class User_Service_User extends AIN_Service 
{	
	private $_aUser = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = AIN::getT('user');
	}
	public function get($mName = null, $bUseId = true)
	{
	
		static $aUser = array();
		
		if (isset($aUser[$mName]))
		{		
			return $aUser[$mName];
		}
		$sCacheId = $this->cache()->set(array('profile',  'user_id_'  . $mName));
		if ( ($aCachedUser = $this->cache()->get($sCacheId)) && is_array($aCachedUser))
		{
			$aUser[$mName] = $aCachedUser;
			if (!isset($this->_aUser[ $aCachedUser['user_id'] ]))
			{
				$this->_aUser[ $aCachedUser['user_id'] ] = $aCachedUser;
			}
			return $aCachedUser;
		}			
		$aRow = $this->database()->select('u.*')
			->from($this->_sTable, 'u')
			->where(($bUseId ? "u.user_id = " . (int) $mName . "" : "u.user_name = '" . $this->database()->escape($mName) . "'"))
			->execute('getSlaveRow');
		
		$aUser[$mName] =& $aRow;	
		
		if (!isset($aUser[$mName]['user_name']))
		{
			return false;
		}	
		
		$this->_aUser[$aRow['user_id']] = $aUser[$mName];
		
		if (AIN::getParam('core.super_cache_system') )
		{
			$sCacheId = $this->cache()->set(array('profile', ($bUseId ? 'user_id_' : 'user_name_') . $mName));
			$this->cache()->save($sCacheId, $aUser[$mName]);
		}
		
		return $aUser[$mName];
	}
	
	public function isAdminUser($iUserId)
	{
		if (ADMIN_USER_ID == AIN::getUserBy('user_group_id'))
		{
			return false;
		}
		
		$sUserGroupId = $this->database()->select('user_group_id')
			->from(AIN::getT('user'))
			->where('user_id = ' . (int) $iUserId)
			->execute('getField');
		
		if ($sUserGroupId == ADMIN_USER_ID)
		{
			return true;
		}
			
		return false;
	}
	public function getForEdit($iUserId)
	{
		AIN::getUserParam('user.can_edit_users', true);		
		
		$aUser = $this->database()->select('u.*')
			->from($this->_sTable, 'u')
			->where('u.user_id = ' . (int) $iUserId)
			->execute('getRow');
			
		if (!isset($aUser['user_id']))
		{
			return AIN_Error::set(AIN::getPhrase('user.unable_to_find_the_user_you_plan_to_edit'));
		}
		return $aUser;
	}
	public function getValidationLogin()
	{
		$aValidation = array();			
		$aValidation['username'] = AIN::getPhrase('user.provide_a_valid_user_name', array('min' => AIN::getParam('user.min_length_for_username'), 'max' => AIN::getParam('user.max_length_for_username')));
		$aValidation['password'] = AIN::getPhrase('user.provide_a_valid_password');
		return $aValidation;
	}
	public function getValidation()
	{
		$aValidation = array();			
		$aValidation['username'] = AIN::getPhrase('user.provide_a_valid_user_name', array('min' => AIN::getParam('user.min_length_for_username'), 'max' => AIN::getParam('user.max_length_for_username')));
		$aValidation['email'] = AIN::getPhrase('user.provide_a_valid_email_address');		
		$aValidation['country_iso'] = AIN::getPhrase('user.provide_a_country_iso');				
		$aValidation['password'] = array(
			'def' => 'password',
			'title' => AIN::getPhrase('user.provide_a_valid_password')
		);		
		$aValidation['rpassword'] = AIN::getPhrase('user.provide_a_valid_rpassword');	
		
		return $aValidation;
	}
	public function getUser($mUser, $sSelect = 'u.*', $bUserName = false)
	{
		
		if ($bUserName === false)
		{
			if ((int) $mUser === 0)
			{
				return false;
			}
		}
		else 
		{
			if (empty($mUser))
			{
				return false;
			}
		}		
		
		$aRow = $this->database()->select($sSelect)
			->from($this->_sTable, 'u')
			->where(($bUserName ? "u.full_name = '" . $this->database()->escape($mUser) . "'" : 'u.user_id = ' . (int) $mUser))
			->execute('getSlaveRow');
		
		(($sPlugin = AIN_Plugin::get('user.service_user_getuser_end')) ? eval($sPlugin) : false);
			
		return $aRow;
	}
}
?>