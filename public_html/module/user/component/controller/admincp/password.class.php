<?php

defined('AIN') or exit('NO DICE!');

class user_component_controller_admincp_password extends AIN_Component
{
	public function process()
	{
		
		AIN::isUser(true);
	
		if ($aVals = $this->request()->getArray('val'))
		{
			if (AIN::getService('user.process')->updatePassword($aVals))
			{
				//$this->url()->send('');			
				AIN::addmessage('Update password');
			}
		}
	}
}