<?php


defined('AIN') or exit('NO DICE!');


class User_Service_Group_Setting_Setting extends AIN_Service 
{
	private $_aParam = array();
	
	private $_iLastUserGroupId = 0;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{
		$this->_sTable = AIN::getT('user_group_setting');
		
		$this->_aParam = $this->_setParam(AIN::getUserBy('user_group_id'));
		
		$this->_iLastUserGroupId = AIN::getUserBy('user_group_id');
	}		
	
	public function getParam($sName)
	{
		if (defined('AIN_APP_USER_GROUP_ID'))
		{
			$this->_aParam = $this->_setParam(AIN_APP_USER_GROUP_ID);
			$this->_iLastUserGroupId = AIN_APP_USER_GROUP_ID;
		}
		else if (AIN::getUserBy('user_group_id') != $this->_iLastUserGroupId)
		{
			$this->_aParam = $this->_setParam(AIN::getUserBy('user_group_id'));
			
			$this->_iLastUserGroupId = AIN::getUserBy('user_group_id');			
		}
		
		return (isset($this->_aParam[$sName]) ? $this->_aParam[$sName] : AIN_Error::trigger('Invalid user group setting param: ' . $sName, E_USER_WARNING));
	}
	
	public function getGroupParam($iGroupId, $sName)
	{
		static $aGroup = array();
		
		if (!isset($aGroup[$iGroupId]))
		{
			$aGroup[$iGroupId] = $this->_setParam($iGroupId);
		}		
		
		return (isset($aGroup[$iGroupId][$sName]) ? $aGroup[$iGroupId][$sName] : AIN_Error::trigger('Invalid user group setting param: ' . $sName, E_USER_WARNING));
	}
	
	public function getModules($iGroupId)
	{
		$aModules = $this->database()->select('m.module_id, COUNT(ugs.module_id) AS total_setting')
			->from(AIN::getT('module'), 'm')
			->join(AIN::getT('user_group_setting'), 'ugs', 'ugs.module_id = m.module_id')
			->where('m.is_active = 1')
			->group('m.module_id')
			->execute('getRows');
			
		return $aModules;
	}	
	private function &_setType(&$aRow, $sVar)
	{
		if (empty($aRow['value_actual']) && $aRow['value_actual'] != '0')
		{
			if (is_null($aRow[$sVar]) && $aRow['inherit_id'] > 0)
			{
				switch($aRow['inherit_id'])
				{
					case ADMIN_USER_ID:
						$sVar = 'default_admin';
						break;
					case GUEST_USER_ID:
						$sVar = 'default_guest';
						break;
					case STAFF_USER_ID:
						$sVar = 'default_staff';
						break;			
					case NORMAL_USER_ID:
						$sVar = 'default_user';
						break;
					default:
							
						break;
				}						
				
				$aRow['value_actual'] = $aRow[$sVar];						
			}
			else 
			{
				$aRow['value_actual'] = $aRow[$sVar];
			}
		}
		switch ($aRow['type_id'])
		{
			case 'boolean':
				if (strtolower($aRow['value_actual']) == 'true' || strtolower($aRow['value_actual']) == 'false')
				{
					$aRow['value_actual'] = (strtolower($aRow['value_actual']) == 'true' ? '1' : '0');
				}						
				settype($aRow['value_actual'], 'boolean');
				break;
			case 'integer':
				settype($aRow['value_actual'], 'integer');
				break;
			case 'array':
				if (!empty($aRow['value_actual']))
				{
					//eval("\$aRow['value_actual'] = ". unserialize(trim($aRow['value_actual'])) . "");
					if (AIN::getLib('parse.format')->isSerialized($aRow['value_actual']))
					{
						eval("\$aRow['value_actual'] = ". unserialize(trim($aRow['value_actual'])) .';');
					}
					else
					{
						eval("\$aRow['value_actual'] = ".trim($aRow['value_actual']) .';');
					}
				}
				break;
		}		
		
		
		return $aRow;
	}		
	private function _setParam($iUserId)
	{
		$sCacheId = $this->cache()->set('user_group_setting_' . $iUserId);
		
		if (!($aParams = $this->cache()->get($sCacheId)))
		{
			switch($iUserId)
			{
				case ADMIN_USER_ID:
					$sVar = 'default_admin';
					break;
				case GUEST_USER_ID:
					$sVar = 'default_guest';
					break;
				case STAFF_USER_ID:
					$sVar = 'default_staff';
					break;
				case NORMAL_USER_ID:
					$sVar = 'default_user';
					break;
				default:
						
					break;
			}			
			
			if (!isset($sVar))
			{
				$sVar = 'default_value';				
			}
			$aRows = $this->database()->select('m.module_id, user_group_setting.name, user_group_setting.type_id, user_group_setting.default_admin, user_group_setting.default_user, user_group_setting.default_guest, user_group_setting.default_staff, user_setting.value_actual AS value_actual')
				->from($this->_sTable, 'user_group_setting')
				->leftJoin(AIN::getT('module'), 'm', 'm.module_id = user_group_setting.module_id')
				->leftJoin(AIN::getT('user_setting'), 'user_setting', "user_setting.user_group_id = '" . $iUserId . "' AND user_setting.setting_id = user_group_setting.setting_id")
				->execute('getSlaveRows');	
				
			$aParams = array();
			foreach ($aRows as $aRow)
			{				
				$this->_setType($aRow, $sVar);

				$key = $aRow['module_id'] . '.' . $aRow['name'];

				$aParams[$key] = $aRow['value_actual'];				
			}
	
			$this->cache()->save($sCacheId, $aParams);	
		}
		return $aParams;
	}
}
?>