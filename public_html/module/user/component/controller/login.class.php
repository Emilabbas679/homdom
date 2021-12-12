<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Login extends AIN_Component 
{	
	public function process()
	{
		define('AIN_DONT_SAVE_PAGE', true);

		if ( AIN::isUser() )
		{
			$this->url()->send('profile');
		}
		
		if ($aVals = $this->request()->getArray('val'))	
		{			
			list($bLogged, $aUser) = (AIN::getService('user.auth')->login($aVals['login'], $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both'));
			if ($bLogged)
			{
				$this->url()->send('');	
			}
		}	
		
		$this->template()
			->assign(array(
				'sDefaultEmailInfo' => ($this->request()->get('email') ? trim(base64_decode($this->request()->get('email'))) : '')
			)
		);
		
	}
}

?>