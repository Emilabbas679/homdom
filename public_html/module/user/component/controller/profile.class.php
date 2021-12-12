<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Profile extends AIN_Component 
{	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		AIN::isUser(true);
		$bIsEdit = false;
		$iUserId = AIN::getUserId();

		if (($aUserId = $this->request()->getInt('userId')) && $aUserId > 0 )
		{
			$iUserId = $aUserId;			
		}
		$aForms = AIN::getService('user')->get($iUserId, true);
		
		$this->template()->setTitle(AIN::getPhrase('user.edit_profile'))
		 	->assign(array(
		 			'bIsEdit' => $bIsEdit,
					'aForms' => $aForms,
		 		)
		 	);
		
		
		
		//print_r($aForms);
		
	}
}

?>