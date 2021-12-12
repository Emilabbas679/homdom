<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Password extends AIN_Service
{	
	public function __construct()
	{
		$this->_sTable = AIN::getT('user');
	}
	
	public function requestPassword($sEmail)
	{
		$aUser = $this->database()->select('user_id, email, full_name')
			->from($this->_sTable)
			->where('email = \'' . $this->database()->escape($sEmail) . '\'')
			->execute('getRow');
			
		if (!isset($aUser['user_id']))
		{
			return AIN_Error::set(AIN::getPhrase('user.not_a_valid_email'));
		}			
		$sHash = md5($aUser['user_id'] . $aUser['email'] . AIN::getParam('core.salt'));
		$sLink = AIN::getLib('url')->makeUrl('user.password.verify', array('id' => $sHash));
		
		AIN::getLib('mail')->to($aUser['email'])
			->subject(AIN::getPhrase('user.password_request_for_site_title', array('site_title' => AIN::getParam('core.site_title'))))
			->message(AIN::getPhrase('user.you_have_requested_for_us_to_send_you_a_new_password_for_site_title', array(
						'site_title' => AIN::getParam('core.site_title'),
						'link' => $sLink
					)
			))
			->send();
	
		$this->database()->delete(AIN::getT('user_password_request'), 'user_id = ' . $aUser['user_id']);
		$this->database()->insert(AIN::getT('user_password_request'), array(
				'user_id' => $aUser['user_id'],
				'request_id' => $sHash,
				'time_stamp' => AIN_TIME
			)
		);				
		
		AIN::getService('user.log')->userLog( array( 'user_id' =>  $aUser['user_id'], 'type_id' =>  'password_request' ) );		
		
		return true;
	}
	public function verifyRequest($sId)
	{
        $sSelect = 'r.*, u.email, u.full_name';
        $sWhere = 'r.request_id = \'' . $this->database()->escape($sId) . '\'';
        $sJoin = 'u.user_id = r.user_id';
		$aRequest = $this->database()->select($sSelect)
			->from(AIN::getT('user_password_request'), 'r')
			->join($this->_sTable, 'u', $sJoin)
			->where($sWhere)
			->execute('getRow');

		if (!isset($aRequest['user_id']))
		{
			return AIN_Error::set(AIN::getPhrase('user.not_a_valid_password_request'));
		}
		if (md5($aRequest['user_id'] . $aRequest['email'] . AIN::getParam('core.salt')) != $sId)
		{
			return AIN_Error::set(AIN::getPhrase('user.password_request_id_does_not_match'));
		}		
		
		$sNewPassword = $this->generatePassword(15, 10);
		$sSalt = $this->_getSalt();			
		$aUpdate = array();
		$aUpdate['password'] = AIN::getLib('hash')->setHash($sNewPassword, $sSalt);
		$aUpdate['password_salt'] = $sSalt;	
		(($sPlugin = AIN_Plugin::get('user.service_password_verifyrequest_3')) ? eval($sPlugin) : false);
		
		$this->database()->update($this->_sTable, $aUpdate, 'user_id = ' . $aRequest['user_id']);
		$this->database()->delete(AIN::getT('user_password_request'), 'user_id = ' . $aRequest['user_id']);
					
		// Send the user an email
		$sLink = AIN_Url::instance()->makeUrl('user.login');
		
		(($sPlugin = AIN_Plugin::get('user.service_password_verifyrequest_4')) ? eval($sPlugin) : false);
		AIN::getLib('mail')->to($aRequest['email'])
			->subject(AIN::getPhrase('user.new_password_for_site_title', array('site_title' => AIN::getParam('core.site_title'))))
			->message(AIN::getPhrase('user.you_have_requested_for_us_to_send_you_a_new_password_for_site_title_with_password', array(
						'site_title' => AIN::getParam('core.site_title'),
						'email' => $aRequest['email'],
						'password' => $sNewPassword,
						'link' => $sLink
					)
				)
			)
			->send();
			
		if ($sPlugin = AIN_Plugin::get('user.service_password_verifyrequest_end'))
		{
			eval($sPlugin);
		}
		
		return true;
	}	
	public function generatePassword($iLength = 9, $iStrength = 10)
	{
		$sVowels = 'aeuy';
		$sConsonants = 'bdghjmnpqrstvz';
		
		if ($iStrength > 1) 
		{
			$sConsonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		
		if ($iStrength > 2) 
		{
			$sVowels .= "AEUY";
		}
		
		if ($iStrength > 4) 
		{
			$sConsonants .= '23456789';
		}
		
		if ($iStrength > 8) 
		{
			$sConsonants .= '@#$%{}[]!?*;:';
		}
	
		$sPassword = '';
		$sAlt = time() % 2;
		for ($i = 0; $i < $iLength; $i++) 
		{
			if ($sAlt == 1) 
			{
				$sPassword .= $sConsonants[(rand() % strlen($sConsonants))];
				$sAlt = 0;
			} 
			else 
			{
				$sPassword .= $sVowels[(rand() % strlen($sVowels))];
				$sAlt = 1;
			}
		}
		return $sPassword;
	}
	public function updatePassword($sRequest, $aVals)
	{
		if (!isset($aVals['newpassword']) || !isset($aVals['newpassword2']) || $aVals['newpassword'] != $aVals['newpassword2'])
		{
			return AIN_Error::set(AIN::getPhrase('user.passwords_do_not_match'));
		}
		$aRequest = $this->database()->select('r.*, u.email, u.full_name')
			->from(AIN::getT('user_password_request'), 'r')
			->join($this->_sTable, 'u', 'u.user_id = r.user_id')
			->where('r.request_id = \'' . $this->database()->escape($sRequest) . '\'')
			->execute('getRow');
			
		$sSalt = $this->_getSalt();			
		$aUpdate = array();
		$aUpdate['password'] = AIN::getLib('hash')->setHash($aVals['newpassword'], $sSalt);
		$aUpdate['password_salt'] = $sSalt;	

		
		$this->database()->update($this->_sTable, $aUpdate, 'user_id = ' . $aRequest['user_id']);
		$this->database()->delete(AIN::getT('user_password_request'), 'user_id = ' . $aRequest['user_id']);
		
		AIN::getService('user.log')->userLog( array( 'user_id' =>  $aRequest['user_id'], 'type_id' =>  'password_change' ) );
		
		return true;
	}
	public function isValidRequest($sId)
	{
		$aRequest = $this->database()->select('r.*, u.email, u.full_name')
			->from(AIN::getT('user_password_request'), 'r')
			->join($this->_sTable, 'u', 'u.user_id = r.user_id')
			->where('r.request_id = \'' . $this->database()->escape($sId) . '\'')
			->execute('getRow');
			
		if (!isset($aRequest['user_id']))
		{
			return AIN_Error::set(AIN::getPhrase('user.not_a_valid_password_request'));
		}
		if (md5($aRequest['user_id'] . $aRequest['email'] . AIN::getParam('core.salt')) != $sId)
		{
			return AIN_Error::set(AIN::getPhrase('user.password_request_id_does_not_match'));
		}
		if (AIN::getParam('user.verify_email_timeout') > 0 && ($aRequest['time_stamp'] < (AIN_TIME - (AIN::getParam('user.verify_email_timeout')*60))))
		{
			$this->database()->delete(AIN::getT('user_password_request'), 'request_id = "' . $this->database()->escape($sId) . '"');
			return AIN_Error::set(AIN::getPhrase('user.request_expired_please_try_again'));
		}
		return true;
	}	
	private function _getSalt($iTotal = 3)
	{
		$sSalt = '';
		for ($i = 0; $i < $iTotal; $i++)
		{
			$sSalt .= chr(rand(33, 126));
		}
		
		return $sSalt;
	}	
	
}
?>