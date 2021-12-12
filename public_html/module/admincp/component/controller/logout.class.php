<?php


defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Logout extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if (!AIN::getParam('core.admincp_do_timeout'))
		{
			AIN::getService('user.auth')->logout();	
			
			$this->url()->send('');	
		}
		
		AIN::getService('user.auth')->logoutAdmin();
		
		$this->url()->send('admincp', null, AIN::getPhrase('admincp.successfully_logged_out'));	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{

	}
}

?>