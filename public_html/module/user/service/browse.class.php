<?php


defined('AIN') or exit('NO DICE!');

class User_Service_Browse extends AIN_Service 
{	
	private $_aUser = array();
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = AIN::getT('user');
	}

	public function getAdmins()
	{
		static $aCache = array();
		
		if (! isset($aCache[1])  )
		{
			$aCache[1] = $this->database()->select('u.full_name, u.user_group_id, u.last_login, u.user_id')
					->from($this->_sTable, 'u')
					->where('u.user_group_id = 1')			
					->execute('getSlaveRows');
			
		}	
		return $aCache[1];
	}
	public function getStatus( $last_login )
	{
		$iActiveSession = AIN_TIME - (AIN::getParam('user.active_session') * 60);
		
		if( $last_login > $iActiveSession)
			$aStatus =  '<span class="label-success label label-default pull-right">online</span>';
		else
			$aStatus = '<span class="label-danger label label-default pull-right">offline</span>';
			
		return $aStatus;	
	}
	
}
?>