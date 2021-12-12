<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Login extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		if ($aVals = $this->request()->getArray('val'))
		{
			list($bLogged, $aUser) = (AIN::getService('homdom.user')->loginAdmin($aVals['login'], $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both'));
            if ($bLogged)
			{				
				if ($this->request()->get('req1') == 'login') $this->url()->send('');
				
				$this->url()->send('current');
			}
		}	
		$this->template()->setTemplate('login');			
	}	
}

?>