<?php
/**
 * [AIN_HEADER]
 */

defined('AIN') or exit('NO DICE!');

define('AIN_DONT_SAVE_PAGE', true);

class User_Component_Controller_Verify extends AIN_Component
{
	/**
	 * Class process method which is used to execute this component.
	 */
	public function process()
	{
		
		$sHash = $this->request()->get('link', '');		
		if ($sHash == '') 
		{
			
		}
		elseif ( AIN::getService('user.verify.process')->verify($sHash) )
		{			
			$this->url()->send('http://user.adsgarden.com/advertiser/index/', null, AIN::getPhrase('user.your_email_has_been_verified_please_log_in_with_the_information_you_provided_during_sign_up'));
		}
		else
		{
			AIN_Error::set(AIN::getPhrase('user.invalid_verification_link'));			
		}	
	}
}
?>