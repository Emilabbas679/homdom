<?php 

defined('AIN') or exit('NO DICE!');

class User_Service_Validate extends AIN_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('user');
	}
	public function email($sEmail)
	{	
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("email = '" . $this->database()->escape($sEmail) . "'")
			->execute('getField');
			
		if ($iCnt)
		{
			AIN_Error::set(AIN::getPhrase('user.email_is_in_use_and_user_can_login', array('email' => trim(strip_tags($sEmail)), 'link' => AIN::getLib('url')->makeUrl('user.login', array('email' => base64_encode($sEmail))))));
		}		
		return $this;
	}
	public function user($sUser)
	{		
		$iCnt = $this->database()->select('COUNT(*)')
			->from($this->_sTable)
			->where("user_name = '" . $this->database()->escape($sUser) . "'")
			->execute('getField');
			
		if ($iCnt)
		{
			AIN_Error::set('Istifadəçi adı var');
		}			
		
		return $this;
	}
	
	
	
}	
?>