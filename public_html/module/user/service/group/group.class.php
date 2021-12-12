<?php

defined('AIN') or exit('NO DICE!');

class User_Service_Group_Group extends AIN_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = AIN::getT('user_group');
	}
	
	public function getUserGroupId()
	{
		return (int) AIN::getService('user.auth')->getUserBy('user_group_id');
	}
	public function get($aConds = array())
	{
		$aCache = array(
			'cache' => true,
			'cache_name' => 'user_group'
		);
		if (empty($aConds))
        {
            $aConds[] = 'user_group.user_group_id > 0';
        }
		$aGroups = $this->database()->select('user_group.*')
			->from($this->_sTable, 'user_group')
			->where($aConds)
			->order('user_group.user_group_id ASC')
			->execute('getRows', ($aConds ? null : $aCache));
		
		
		return $aGroups;
	}
	public function getForEdit()
	{
		$aRows = $this->database()->select('user_group.user_group_id, user_group.title, user_group.is_special, COUNT(user_id) AS total_users')
			->from($this->_sTable, 'user_group')
			->leftJoin(AIN::getT('user'), 'u', 'u.user_group_id = user_group.user_group_id')
			->group('user_group.user_group_id, user_group.title, user_group.is_special')
			->order('user_group.user_group_id ASC')
			->execute('getRows');
			
		$aGroups = array();
		foreach ($aRows as $aRow)
		{			
			if ( $aRow['is_special'] > 0 )
			{
				$aGroups['special'][] = $aRow;	
			}
			else 
			{
				$aGroups['custom'][] = $aRow;
			}
		}		
			
		return $aGroups;	
	}
	public function getGroup($iId)
	{
		static $aCache = array();
		
		if (!isset($aCache[$iId]))
		{
			$aCache[$iId] = $this->database()->select('user_group.*')
				->from($this->_sTable, 'user_group')
				->where('user_group_id = ' . (int) $iId)
				->execute('getRow');
		}
		
		$sPhraseVar = 'user.' . str_replace(' ', '_', strtolower($aCache[$iId]['title']));
		
		if (AIN::getLib('locale')->isPhrase($sPhraseVar))
		{
			$aCache[$iId]['title'] = AIN::getPhrase($sPhraseVar);
		}
		return $aCache[$iId];
	}		
}
?>	