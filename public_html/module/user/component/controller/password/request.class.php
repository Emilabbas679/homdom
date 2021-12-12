<?php


defined('AIN') or exit('NO DICE!');


class User_Component_Controller_Password_Request extends AIN_Component 
{
	
	public function process()
	{
		if ( AIN::isUser() )
		{
			$this->url()->send('');
		}			
		
		if ($sEmail = $this->request()->get('email'))
		{			
			if (AIN::getService('user.password')->requestPassword($sEmail))
			{
				$this->url()->send('user.password.request', null, AIN::getPhrase('user.password_request_successfully_sent_check_your_email_to_verify_your_request'));
			}
		}
		$this->template()->setTitle(AIN::getPhrase('user.password_request'))->setBreadcrumb(AIN::getPhrase('user.password_request'));
	}
	
}
?>