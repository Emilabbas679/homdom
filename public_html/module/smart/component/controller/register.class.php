<?php

defined('AIN') or exit('NO DICE!');

class Smart_Component_Controller_Register extends AIN_Component
{
	public function process()
    {
		if ( auth() )
		{
			$this->url()->send('', array(), 'Already register');
		}
		if( $this->request()->get('req3') )
		{
			$data = AIN::getService('video')->user_verify_check(array('hash_code' => $this->request()->get('req3')));

			//print_r($data);

			if ('failed' == $data['status']) {
				AIN_ERROR::set(implode('<br/>', $data['messages']));
			} else {
				return $this->url()->send('advertiser.login', null, AIN::getPhrase('user.your_email_has_been_verified_please_log_in_with_the_information_you_provided_during_sign_up'));
			}
		}
		
		$isSendMail = false;

		$aForms = array();

		///$aForms['email'] = 'kerimov.ferid@gmail.com';

		if ($aVals = $this->request()->getArray('val'))
		{
			if( isset($aVals['recaptcha_response']) )
			{
				if( AIN::getService('smart')->recaptcha_verify($aVals) )
				{
					$aVals['site_title'] = AIN::getParam('core.site_title');
					$aVals['verify_link'] = AIN::getLib('url')->makeUrl('advertiser.register.{hash_code}', array());
					$data = AIN::getService('video')->user_verify_process($aVals);
					
					if ('failed' == $data['status']) {
						AIN_ERROR::set(implode('<br/>', $data['messages']));
					} else {
						$isSendMail = true;
					}
				}
				else
				{
					AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
				}
			}
			else
			{
				AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
			}
		}



		$this->template()->setTitle(AIN::getPhrase('user.register'))->assign(array(
			'isSendMail' => $isSendMail,
			'aForms' => $aForms,
		));

		$this->template()->setTemplate('blank');
	}


	public function clean()
	{


	}
}

?>
