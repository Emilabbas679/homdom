<?php

defined('AIN') or exit('NO DICE!');


class User_Component_Controller_Index extends AIN_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		
	}
	public function clean()
	{
		(($sPlugin = AIN_Plugin::get('core.component_controller_index_clean')) ? eval($sPlugin) : false);
	}
}

?>