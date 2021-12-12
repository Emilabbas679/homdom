<?php

defined('AIN') or exit('NO DICE!');

class Smart_Component_Controller_Password extends AIN_Component
{
	public function process()
	{
		if ( auth() )
		{
			$this->url()->send('', array(), 'Already login');
		}

		$isPost = false;

		if( $this->request()->get('req3') )
		{
			$data = AIN::getService('video')->user_verify_password(array('hash_code' => $this->request()->get('req3'), 'verify_link' => AIN::getLib('url')->makeUrl('publisher.login', array() ) ));

			if ('failed' == $data['status']) {

				AIN_ERROR::set(implode('<br/>', $data['messages']));

			} else {

				$isPost = true;

				AIN::addmessage(AIN::getPhrase('user.new_password_successfully_sent_check_your_email_to_use_your_new_password'));

				///return $this->url()->send('publisher.login', array(), AIN::getPhrase('user.new_password_successfully_sent_check_your_email_to_use_your_new_password'));
			}
		}
        if ($aVals = $this->request()->getArray('val')){
            if( isset($aVals['recaptcha_response']) ){
                if( AIN::getService('smart')->recaptcha_verify($aVals)){
                    $aVals['site_title'] = AIN::getParam('core.site_title');

                    $aVals['verify_link'] = AIN::getLib('url')->makeUrl('advertiser.password.{hash_code}', array());

                    $data = AIN::getService('video')->user_new_password($aVals);

                    if ('failed' == $data['status']) {

                        AIN_ERROR::set(implode('<br/>', $data['messages']));

                    } else {

                        $isPost = true;

                        AIN::addmessage(AIN::getPhrase('user.password_request_successfully_sent_check_your_email_to_verify_your_request'));
                    }
                }
                else{
                    AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
                }
            }
            else{
                AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
            }

        }

		$this->template()->setTemplate('blank');

		$this->template()->setTitle(AIN::getPhrase('user.password_request'))->assign( array( 'isPost' => $isPost ) );
	}
}

?>
