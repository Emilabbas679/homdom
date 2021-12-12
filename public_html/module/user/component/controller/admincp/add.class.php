<?php

defined('AIN') or exit('NO DICE!');


class user_component_controller_admincp_add extends AIN_Component
{
	public function process()
	{
		$bIsEdit = false;
		if (($iId = $this->request()->getInt('id')))
		{
			if (($aUser = AIN::getService('user')->getForEdit($iId)))
			{
				$bIsEdit = true;
				
				$this->template()->assign('aForms', $aUser);	
				
				if (AIN::getService('user')->isAdminUser($aUser['user_id']))
				{
					$this->url()->send('user.subscribe', array(), AIN::getPhrase('user.you_are_unable_to_edit_a_site_administrators_account'));
				}				
				if( ! AIN::getUserParam('user.can_manage_all_users') )
				{
					if( $iId != AIN::getUserBy('user_id') )
					{
						$this->url()->send('user.subscribe', array(), AIN::getPhrase('user.you_are_unable_to_edit_a_site_administrators_account'));
					}
				}				
			}
		}
		
		
		if ( $this->request()->getInt('change') and $aUser['user_id'] > 0 )
		{
			AIN::getLib('database')->update(AIN::getT('user'), array( 'status_id' => $this->request()->getInt('status_id') ), 'user_id = ' . (int) $aUser['user_id'] );		
			return $this->url()->send('user.browse', null, AIN::getPhrase('user.selected_successfully_updated'));
		}
		
		
		
		if (($aVals = $this->request()->getArray('val')))
		{			
			if ($bIsEdit)
			{				
				$aVals['old_user_name'] = $aUser['user_name'];
				$aVals['old_email'] = $aUser['email'];	
				
				if (AIN::getService('user.process')->updateAdvanced($aUser['user_id'], $aVals))
				{	
					$this->url()->send('user.add', array('id' => $aUser['user_id']), AIN::getPhrase('user.user_successfully_updated'));
				}				
			}
			else 
			{
				AIN::getService('user.validate')->email($aVals['email']);		
				
				if ($iId = AIN::getService('user.process')->add($aVals))
				{
					$this->url()->send('user.add', array('id' => $aUser['user_id']), AIN::getPhrase('user.user_successfully_updated'));
				}
			}		
		}
		
		
		
		$aEditForm = array();
		$aEditForm['basic'] = array();
		$aEditForm['basic']['title'] = 'ƏSAS MƏLUMATLAR';
		$aEditForm['basic']['data'] = array();
		
		
		
		
		$aEditForm['basic']['data'][] = array(
			'title' => 'Ad soyad',
			'value' => (isset($aVals['full_name']) ? $aVals['full_name'] : (isset($aUser['full_name']) ? $aUser['full_name'] : '')),
			'type' => 'input:text',
			'id' => 'full_name',
			'required' => true,		
		);				
		
		$aEditForm['basic']['data'][] = array(
			'title' => 'Password',
			'value' => '',
			'type' => 'input:text',
			'id' => 'password',
			'required' => true,		
		);				
				
		$aEditForm['basic']['data'][] = array(
			'title' => 'İstifadəçi adı',
			'value' => (isset($aVals['user_name']) ? $aVals['user_name'] : (isset($aUser['user_name']) ? $aUser['user_name'] : '')),
			'type' => 'input:text',
			'id' => 'user_name',
			'required' => true,		
		);	
		
		$aEditForm['basic']['data'][] = array(
			'title' => 'E-mail',
			'value' => (isset($aVals['email']) ? $aVals['email'] : (isset($aUser['email']) ? $aUser['email'] : '')),
			'type' => 'input:text',
			'id' => 'email',
			'required' => true,		
		);		
		
		
		if ( AIN::getUserParam('user.can_manage_all_users') )
		{
			$aUserGroups = array();
			foreach (AIN::getService('user.group')->get() as $aUserGroup)
			{
				$aUserGroups[$aUserGroup['user_group_id']] = $aUserGroup['title'];
			}	
			$aEditForm['basic']['data'][] = array(
							'title' => 'İstifadəçi qrupu',
							'value' => (isset($aVals['user_group_id']) ? $aVals['user_group_id'] : (isset($aUser['user_group_id']) ? $aUser['user_group_id'] : '')),
							'type' => 'select',
							'id' => 'user_group_id',
							'options' => $aUserGroups,
							'required' => true,		
			);		
		}
		
		
		
		$aEditForm['basic']['data'][] = array(
						'title' => AIN::getPhrase('user.gender'),
						'value' => (isset($aVals['gender']) ? $aVals['gender'] : (isset($aUser['gender']) ? $aUser['gender'] : '')),
						'type' => 'select',
						'id' => 'gender',
						'options' => AIN::getService('core')->getGenders(),
						'required' => true
		);
		
		
		
		
		
		
		
		
		
		$this->template()
			->assign(array(
					'bIsEdit' => $bIsEdit,
					'aEditForm' => $aEditForm,
				)
			);
		
	}
}
?>	