<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Log_log extends AIN_Service 
{	

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->_sTable = AIN::getT('user_log');
	}
	
	public function userLog( $data = array() )
	{
		/*
			login_failed  - istifad?çi yalnis daxil olarsa,
			login_success - istifad?çi dogru giris,
		*/		
		/* Log the attempt */
			return $this->database()->insert($this->_sTable, array(
				'user_id' 		=> isset($data['user_id']) ? $data['user_id'] : '0',
				'type_id'		=> isset($data['type_id']) ? $data['type_id'] : 'login_failed',
				'ip_address'	=> isset($data['ip_address']) ? $data['ip_address'] : AIN::getIp(), 
				'time_stamp' 	=> AIN_TIME
			)
		);		
	}
	public function getLastLog($aCond = array() )
	{
		$aRows = $this->database()->select('ul.*, u.email')
			->from($this->_sTable, 'ul')
			->join(AIN::getT('user'), 'u', 'u.user_id = ul.user_id')
			->where($aCond)
			->order('ul.time_stamp desc')
			->limit(10)
			->execute('getSlaveRows');		
		
		
		return $aRows;
		
	}
}