<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Logout extends AIN_Component 
{	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		if ($this->request()->get('req3') != 'done')
		{
			AIN::getService('user.auth')->logout();

			$this->url()->send('');	
		}		
		$this->template()->setTitle(AIN::getPhrase('user.logout'));
	}
}

?>