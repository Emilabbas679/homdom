<?php


defined('AIN') or exit('NO DICE!');

class Language_Component_Block_Sample extends AIN_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$this->template()->assign(array(
				'sCachePhrase' => $this->request()->get('phrase')
			)
		);	
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = AIN_Plugin::get('language.component_block_sample_clean')) ? eval($sPlugin) : false);
	}
}

?>