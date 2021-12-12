<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Register extends AIN_Component
{
	public function process()
	{
		if (AIN::isUser())
		{
			$this->url()->send('profile');
		}		
		if ($aVals = $this->request()->getArray('val'))
		{
			AIN::getService('user.validate')->email($aVals['email']);		
			
			if ($iId = AIN::getService('user.process')->add($aVals))
			{
				$this->url()->send('');				
			}
		}
	}
	public function clean()
	{
		(($sPlugin = AIN_Plugin::get('User.component_controller_register_clean')) ? eval($sPlugin) : false);
	}
}

?>