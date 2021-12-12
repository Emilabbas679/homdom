<?php
/**
 * [Nulled by DarkGoth - NCP TEAM] - 2016
 */

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Password_Verify extends AIN_Component 
{
	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		if (AIN::isUser())
		{
			$this->url()->send('');
		}		
		if ($sRequest = $this->request()->get('id'))
		{
			if ( ($aVals = $this->request()->getArray('val')))
			{
				if (!isset($aVals['newpassword']) || !isset($aVals['newpassword2']) || $aVals['newpassword'] != $aVals['newpassword2'])
				{
					AIN_Error::set(AIN::getPhrase('user.your_confirmed_password_does_not_match_your_new_password'));
				}
				else
				{
					if (AIN::getService('user.password')->updatePassword($sRequest, $aVals))
					{
						$this->url()->send('', null, AIN::getPhrase('user.password_successfully_updated'));
					}					
				}
			}
			else
			{
				if (AIN::getService('user.password')->isValidRequest($sRequest) == true)
				{
					$this->template()->assign(array('sRequest' => $sRequest));
				}
				else
				{
					$this->url()->send('', null, AIN::getPhrase('user.request_expired_please_try_again'));
				}
			}			
		}
		
		$this->template()->setTitle(AIN::getPhrase('user.password_request_verification'))->setBreadcrumb(AIN::getPhrase('user.password_request_verification'));
	}
}

?>