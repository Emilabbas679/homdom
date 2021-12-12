<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class apanel_component_block_group_setting extends AIN_Component
{
	public function process()
	{		
		$aGroup = AIN::getService('video.user.group')->getGroup($this->request()->get('group_id'));
		
		$aSettings = AIN::getService('video.user.group')->get($this->request()->get('group_id'), $this->request()->get('module_id'));

		$this->template()->assign(array(
				'aSettings' => $aSettings,
				'aForms' => $aGroup,
			)
		);	
	}
}

?>