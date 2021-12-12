<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Setting extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		
		AIN::isUser(true);
		
		$aForms = AIN::getService('user')->get(AIN::getUserBy('user_id'), true);
		$aVals = $this->request()->getArray('val');			
		
		if (!isset($aForms['user_id']))
		{
			return AIN_Error::display('İstifadəçi adı tapılmadı');
		}		
		$aValidation = array();	
		
		$oValid = AIN::getLib('validator')->set(array('sFormName' => 'js_form', 'aParams' => $aValidation));
		
		if (count($aVals))
		{
			if ($oValid->isValid($aVals))
			{
				$bAllowed = true;
				
				if( AIN::getUserParam('user.can_change_email') )
				{
					$aVals['old_email'] = $aForms['email'];					
				}	
				$aVals['old_user_name'] = $aForms['user_name'];				
				
				if ($bAllowed && ($iId = AIN::getService('user.process')->update(AIN::getUserBy('user_id'), $aVals, array(							
							), true
						)
					)
				)
				{
					
					$this->url()->send('user.setting', null, $sMessage);
				}
			}			
		}		
		
		$aEditForm = array();
		$aEditForm['data'] = array();	
		
		$aEditForm['data'][] = array(
			'title' => AIN::getPhrase('user.user_name'),
			'value' => (isset($aVals['user_name']) ? $aVals['user_name'] : (isset($aForms['user_name']) ? $aForms['user_name'] : '')),
			'type' => 'input:text',
			'id' => 'user_name',
			'required' => true,		
		);
		
		
		$aEditForm['data'][] = array(
			'title' => AIN::getPhrase('user.full_name'),
			'value' => (isset($aVals['full_name']) ? $aVals['full_name'] : (isset($aForms['full_name']) ? $aForms['full_name'] : '')),
			'type' => 'input:text',
			'id' => 'full_name',
			'required' => true,		
		);		
		
		$aEditForm['data'][] = array(
			'title' => AIN::getPhrase('user.phone'),
			'value' => (isset($aVals['phone']) ? $aVals['phone'] : (isset($aForms['phone']) ? $aForms['phone'] : '')),
			'type' => 'input:text',
			'id' => 'phone',
			'required' => true,		
		);
		
		$aEditForm['data'][] = array(
			'title' => AIN::getPhrase('user.gender'),
			'value' => (isset($aVals['gender']) ? $aVals['gender'] : (isset($aForms['gender']) ? $aForms['gender'] : '')),
			'id' => 'gender',
			'required' => true,	
			'type' => 'select',	
			'options' => AIN::getService('core')->getGenders(),			
		);		
		
		
		
		if( AIN::getUserParam('user.can_change_email') )
		{
			$aEditForm['data'][] = array(
				'title' => AIN::getPhrase('user.email'),
				'value' => (isset($aVals['email']) ? $aVals['email'] : (isset($aForms['email']) ? $aForms['email'] : '')),
				'id' => 'email',
				'required' => true,	
				'type' => 'input:text',
			);				
		}	

		
		
		
		
		
		$this->template()->assign(	array('aEditForm' => $aEditForm));
		
		
		
		
		
		
		
		
		$this->template()->setTitle(AIN::getPhrase('user.account_settings'))
			->assign(array(
				'aForms' => $aForms,	
				'sCreateJs' => $oValid->createJS(),	
				'sGetJsForm' => $oValid->getJsForm(),				
			));
	}
}