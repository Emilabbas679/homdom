<?php

defined('AIN') or exit('NO DICE!');

class Core_Component_Block_Message extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$this->template()->assign(array(
				'sMessage' => $this->getParam('sMessage')
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{

	}
}