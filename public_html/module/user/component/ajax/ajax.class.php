<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Ajax_Ajax extends AIN_Ajax
{
	
	
	public function updatePassword()
	{
		$this->error(false);
		
		if (AIN::getService('user.process')->updatePassword($this->get('val')))
		{
			AIN::addMessage(AIN::getPhrase('user.password_successfully_updated'));
			
			$this->call('window.location.href = \'' . AIN_Url::instance()->makeUrl('user.setting') . '\';');
		}
		else 
		{
			$this->html('#js_progress_cache_loader', '<div class="alert alert-danger alert-dismissible">' . implode('', AIN_Error::get()) . '</div>');
		}
	}
	
	
	
	
	
	
}
?>