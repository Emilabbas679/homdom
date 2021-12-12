<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Limit extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = AIN_Plugin::get('admincp.component_controller_limit_clean')) ? eval($sPlugin) : false);
	}
}

?>