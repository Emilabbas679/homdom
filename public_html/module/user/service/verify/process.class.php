<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Verify_Process extends AIN_Service
{	
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = AIN::getT('user_verify');
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
		
		$userVerify = AIN::getService('user.verify')->getVerifyHashByEmail($aVals['email']);		
		
		if( isset($userVerify) and strlen($userVerify) > 10 ) AIN_Error::set(AIN::getPhrase('user.email_is_in_use_and_user_can_login', array('email' => trim(strip_tags($aVals['email'])), 'link' => AIN::getLib('url')->makeUrl('user.login', array('email' => base64_encode($aVals['email']))))));
		
		if (!AIN_Error::isPassed())
		{
			return false;
		}		
		$aInsert = array(
			'full_name' => isset($aVals['full_name']) ? $aVals['full_name'] : $aVals['user_name'],
			'user_name' => $aVals['user_name'],
			'user_group_id' => ($iUserGroupId === null ? NORMAL_USER_ID : $iUserGroupId),
			'password' => $aVals['password'],
			//'password_salt' => $sSalt,
			'email' => $aVals['email'],
			'gender' => isset($aVals['gender']) ? $aVals['gender'] : 0 ,
			'phone' => isset($aVals['phone']) ? $aVals['phone'] : '' , // Telefon
			'last_login' => isset($aVals['last_login']) ? $aVals['last_login'] : AIN_TIME ,			
			'refUserId' => AIN::getCookie('refUserId') ? AIN::getCookie('refUserId') : 0 ,
		);
		
		$sHash = AIN::getService('user.verify')->getVerifyHash($aInsert);
		
		$this->database()->insert(AIN::getT('user_verify'), array('hash_code' => $sHash, 'email' => $aInsert['email'], 'time_stamp' => AIN_TIME, 'data' => json_encode($aInsert) ));
		
		$sLink = AIN_Url::instance()->makeUrl('user.verify', array('link' => $sHash));

		AIN::getLib('mail')
			->to($aVals['email'])
			->subject(AIN::getPhrase('user.please_verify_your_email_for_site_title', array('site_title' => AIN::getParam('core.site_title'))))
			->message(AIN::getPhrase('user.you_registered_an_account_on_site_title_before_being_able_to_use_your_account_you_need_to_verify_tha', array(
						'site_title' => AIN::getParam('core.site_title'),
						'link' => $sLink,
						'email' => $aVals['email'],
						'password' => $aVals['password'],
					)
				)
			)
			->send();
		
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
	public function verify($sHash)
	{
		$sHash =  preg_replace("#\s+#",'', $sHash);
		$aVerify = $this->database()
			->select('uv.time_stamp, uv.hash_code , uv.data, uv.email ')
			->from($this->_sTable, 'uv')
			->where('uv.hash_code = \'' . AIN::getLib('parse.input')->clean($sHash) . '\'')
			->execute('getSlaveRow');

			
		if (empty($aVerify))
		{
			return false;
		}			
		
		//$this->database()->delete($this->_sTable, 'hash_code = "'.AIN::getLib('parse.input')->clean($sHash).'"' );			
			
		//if ((AIN::getParam('user.verify_email_timeout') == 0 || ($aVerify['time_stamp'] + (AIN::getParam('user.verify_email_timeout') * 60)) >= AIN_TIME)) 
		{
			$bValid = true; 			
		
			(($sPlugin = AIN_Plugin::get('user.service_verify_process_verify_pass')) ? eval($sPlugin) : false);

			$aVals = json_decode($aVerify['data'], true);
			
			if ( isset($aVerify['data']) )
			{
				$aVals = json_decode($aVerify['data'], true);
				
				if ($iId = AIN::getService('user.process')->add($aVals))
				//if ($iId = $this->add($aVals))
				{
					$this->database()->delete($this->_sTable, 'email = "'.$aVals['email'].'"' );		
					
					list($bLogged, $aUser) = (AIN::getService('user.auth')->login($aVals['email'], $aVals['password'], false, 'both' ));
					
					if ($bLogged)
					{
						return true;
					}					
					return true;
				}
			}
			
			return false;
		}
		
		return false;			
	}	
}
?>