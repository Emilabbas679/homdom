<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Process extends AIN_Service 
{	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = AIN::getT('user');
	}
	
	public function add($aVals, $iUserGroupId = null)
	{		
		$sSalt = $this->_getSalt();
		
		if ( empty($aVals['user_name'])  )
		{
			AIN_Error::set(AIN::getPhrase('user.user_name_error'));
		}	
		
		$aVals['user_name'] = str_replace(' ', '-', $aVals['user_name']);
		$aVals['user_name'] = str_replace('_', '-', $aVals['user_name']);
		
		if( strlen($aVals['user_name']) < 5 ) AIN_ERROR::set('User name error');
		if( strlen($aVals['email']) < 5 ) AIN_ERROR::set('User email error');
		$aVals['user_name'] = strip_tags($aVals['user_name']);
		$aVals['email'] = strip_tags($aVals['email']);
		
		
		AIN::getService('user.validate')->user($aVals['user_name']);	
		AIN::getService('user.validate')->email($aVals['email']);	
	
		if (!AIN_Error::isPassed())
		{
			return false;
		}
		
		$aInsert = array(
			'full_name' => isset($aVals['full_name']) ? $aVals['full_name'] : $aVals['user_name'],
			'user_name' => $aVals['user_name'],
			'user_group_id' => ($iUserGroupId === null ? NORMAL_USER_ID : $iUserGroupId),
			'password' => AIN::getLib('hash')->setHash($aVals['password'], $sSalt),
			'password_salt' => $sSalt,
			'email' => $aVals['email'],
			'gender' => isset($aVals['gender']) ? $aVals['gender'] : 0 ,
			'last_login' => isset($aVals['last_login']) ? $aVals['last_login'] : AIN_TIME ,	
		);		
	
		
		$iId = $this->database()->insert($this->_sTable, $aInsert);
		$aInsert['user_id'] = $iId;
		
		AIN::masscallback('onCreateUser', $aInsert);
	
	
	
		/*
		AIN::getLib('mail')
			->to($aInsert['email'])
			->subject(AIN::getPhrase('user.welcome_email_subject', array('site' => AIN::getParam('core.site_title'))))
			->message(AIN::getPhrase('user.welcome_email_content'))
			->send();
		*/
		return $iId;
	}
	public function update($iUserId, $aVals, $aSpecial = array(), $bIsAccount = false)
	{
			AIN::getUserParam('user.can_edit_users', true);
			
			$aInsert = array(			
				'language_id' => (isset($aVals['language_id']) ? $aVals['language_id'] : 'AZ')
			);			
			if( isset($aVals['old_user_name']) && $aVals['user_name'] != $aVals['old_user_name'] )
			{
				$aVals['user_name'] = str_replace(' ', '_', $aVals['user_name']);
				AIN::getService('user.validate')->user($aVals['user_name']);
				$aInsert['user_name'] = $aVals['user_name'];
			}	
			if( AIN::getUserParam('user.can_change_email')  && isset($aVals['old_email']) && $aVals['email'] != $aVals['old_email'] )
			{
				AIN::getService('user.validate')->email($aVals['email']);
				$aInsert['email'] = $aVals['email'];
			}		

			if( isset($aVals['full_name']) )
			{
				$aInsert['full_name'] = strip_tags($aVals['full_name']);
			}				

			
			
			
			

		
			
			

			
			if (!AIN_Error::isPassed())
			{
				return false;
			}		
			
			
		$this->database()->update($this->_sTable, $aInsert, 'user_id = ' . (int) $iUserId);
		
		return true;
	}	
	private function _getSalt($iTotal = 3)
	{
		$sSalt = '';
		for ($i = 0; $i < $iTotal; $i++)
		{
			$sSalt .= chr(rand(33, 91));
		}

		return $sSalt;
	}
	public function updateAdvanced($iUserid, $aVals)
	{
		AIN::getUserParam('user.can_edit_users', true);

		$aForms = array(
			'full_name' => array(
				'message' => AIN::getPhrase('user.fill_in_a_display_name'),
				'type' => 'string:required'
			),			

			'gender' => array(
				'message' => AIN::getPhrase('user.select_a_gender'),
				'type' => 'int'
			),	
			
		);		
		if ( AIN::getUserParam('user.can_manage_all_users') )		
			$aForms['user_group_id'] = array(
				'message' => AIN::getPhrase('user.select_a_user_group_for_this_user'),
				'type' => 'int:required'
			);
	
		
		if( isset($aVals['old_user_name']) && $aVals['user_name'] != $aVals['old_user_name'] )
		{
			$aForms['user_name'] = array(
				'message' => AIN::getPhrase('user.username_is_required_and_can_only_contain_alphanumeric_characters_and_or_and_must_be_between_5_and_25_characters_long'),
				'type' => array('string:required')
			);

			$aVals['user_name'] = str_replace(' ', '_', $aVals['user_name']);

			AIN::getService('user.validate')->user($aVals['user_name']);
		}
		
		if( AIN::getUserParam('user.can_change_email')  && isset($aVals['old_email']) && $aVals['email'] != $aVals['old_email'] )
		{
			$aForms['email'] = array(
				'message' => AIN::getPhrase('user.provide_a_valid_email'),
				'type' => array('string:required', 'regex:email')
			);

			AIN::getService('user.validate')->email($aVals['email']);
			$bIsEmailPass = true;
		}
		
		
		

		
		if ( isset ($aVals['password']) and strlen($aVals['password']) > 5 )
		{
			$sSalt = $this->_getSalt();
			$aVals['password'] = AIN::getLib('hash')->setHash($aVals['password'], $sSalt);
			$aVals['password_salt'] = $sSalt;	


			$aForms['password'] = array(
				'minlen' => 4,
				'maxlen' => 30,
				'title' => AIN::getPhrase('user.error_password'),
				'type' => 'string:required',
			);
			$aForms['password_salt'] = array(
				'title' => AIN::getPhrase('user.password_salt'),
				'type' => 'string:required',
			);			
			
		}
		
		$aVals = $this->validator()->process($aForms, $aVals);
	
	
		
		
		if (!AIN_Error::isPassed())
		{
			return false;
		}
		
		$this->database()->update($this->_sTable, $aVals, 'user_id = ' . (int) $iUserid);
		
		return true;	
	}	
	public function updatePassword($aVals)
	{
		AIN::isUser(true);
		
		if (empty($aVals['old_password']))
		{
			return AIN_Error::set(AIN::getPhrase('user.missing_old_password'));
		}
		
		if (empty($aVals['new_password']))
		{
			return AIN_Error::set(AIN::getPhrase('user.missing_new_password'));
		}
		
		if (empty($aVals['confirm_password']))
		{
			return AIN_Error::set(AIN::getPhrase('user.confirm_your_new_password'));
		}
		
		if ($aVals['confirm_password'] != $aVals['new_password'])
		{
			return AIN_Error::set(AIN::getPhrase('user.your_confirmed_password_does_not_match_your_new_password'));
		}
		
		$aUser = AIN::getService('user')->getUser(AIN::getUserId());
		
		if (strlen($aUser['password']) > 32) 
		{
			if (!AIN::getLib('hash')->check($aVals['old_password'], $aUser['password'])) {
				return AIN_Error::set(AIN::getPhrase('user.your_current_password_does_not_match_your_old_password'));
			}
		}
		else 
		{
			if (AIN::getLib('hash')->setHash($aVals['old_password'], $aUser['password_salt']) != $aUser['password']) {
				return AIN_Error::set(AIN::getPhrase('user.your_current_password_does_not_match_your_old_password'));
			}
		}
		
		$sSalt = $this->_getSalt();
		$aInsert = array();
		
		$aInsert['password'] = AIN::getLib('hash')->setHash($aVals['new_password'], $sSalt);
		$aInsert['password_salt'] = $sSalt;

		$this->database()->update($this->_sTable, $aInsert, 'user_id = ' . AIN::getUserId());
		
		list($bLogged, $aUser) = AIN::getService('user.auth')->login($aUser['email'], $aVals['new_password'], false, 'email');
		
		AIN::getService('user.log')->userLog( array( 'user_id' =>  $aUser['user_id'], 'type_id' =>  'update_password' ) );
	
		(($sPlugin = AIN_Plugin::get('user.service_process_updatepassword')) ? eval($sPlugin) : false);
		
		return ($bLogged ? true : false);
	}
}