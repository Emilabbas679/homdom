<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Admincp_Group_Index extends AIN_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{	
		AIN::getUserParam('user.can_add_user_group_setting', true);
	
		$this->template()
			->assign(array(
				'aGroups' => AIN::getService('user.group')->getForEdit(),
			)
		);
	}
}

?>