<?php

defined('AIN') or exit('NO DICE!');


class User_Component_Controller_Admincp_Group_Add extends AIN_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{			
		AIN::getUserParam('user.can_add_user_group_setting', true);
		
		
		$iGroupId = $this->request()->getInt('id');		
		$sModule = $this->request()->get('module');
		
		
		if ($iGroupId)
		{
			if ($this->request()->get('setting'))
			{
				AIN::getUserParam('user.can_manage_user_group_settings', true);		
			}
			else 
			{
				AIN::getUserParam('user.can_edit_user_group', true);
			}
			
			if ($aVals = $this->request()->getArray('val'))
			{
				if (AIN::getService('user.group.process')->update($iGroupId, $aVals))
				{
					$this->url()->send('admincp.user.group', null, AIN::getPhrase('user.user_group_updated'));
				}
			}	
			
			$aGroup = AIN::getService('user.group')->getGroup($iGroupId);
			
			if (!isset($aGroup['user_group_id']))
			{
				return AIN_Error::display(AIN::getPhrase('user.invalid_user_group'));
			}	
			
			$this->template()->assign(array(
					'aModules' => AIN::getService('user.group.setting')->getModules($iGroupId),
					'aForms' => $aGroup,
					'sModule' => $sModule,
					'iGroupId' => $iGroupId,
					'bEditSettings' => ($this->request()->get('setting') ? true : false)
				)
			);
		}
		else
		{
			if ($aVals = $this->request()->getArray('val'))
			{
				if ($iId = AIN::getService('user.group.process')->add($aVals))
				{
					$this->url()->send('admincp.user.group', null, AIN::getPhrase('user.user_group_successfully_added'));
				}
			}			
			$this->template()
				->assign(array(
						'aGroups' => AIN::getService('user.group')->get(),
						'bEditSettings' => false,
					)
				);
			
		}		
	}
}
?>