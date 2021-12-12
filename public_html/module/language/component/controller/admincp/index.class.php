<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Controller_Admincp_Index extends AIN_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{
		AIN::getUserParam('language.can_manage_lang_packs', true);
		
		
		
		
		$aLanguages = AIN::getService('language')->getForAdminCp();		
		$this->template()->assign(array(
			'aLanguages' => $aLanguages
		))->setTitle(AIN::getPhrase('language.manage_language_packages'));
		
	}
}
?>