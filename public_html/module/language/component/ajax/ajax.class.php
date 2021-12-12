<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Ajax_Ajax extends AIN_Ajax
{	
	/**
	 * Add a phrase using an inline method
	 *
	 */
	public function add()
	{
		AIN::getComponent('language.admincp.phrase.add', array('sReturnUrl' => $this->get('return'), 'sVar' => $this->get('phrase'), 'bNoJsValidation' => true), 'controller');
	}
	
	public function select()
	{
		AIN::getBlock('language.select');
	}
	
	public function process()
	{		
		if (AIN::getService('language.process')->useLanguage($this->get('id')))
		{
			AIN::addMessage(AIN::getPhrase('language.successfully_updated_your_language_preferences'));
			
						$sReturn = AIN::getLib('session')->get('redirect');
						if (is_bool($sReturn))
						{
							$sReturn = '';
						}		

						if ($sReturn)
						{
							$aParts = explode('/', trim($sReturn, '/'));		
							if (isset($aParts[0]))
							{
								$aParts[0] = AIN_Url::instance()->reverseRewrite($aParts[0]);
							}
							if (isset($aParts[0]) && !AIN::isModule($aParts[0]))
							{
								$aUserCheck = AIN::getService('user')->getByUserName($aParts[0]);
								if (isset($aUserCheck['user_id']))
								{
									if (isset($aParts[1]) && !AIN::isModule($aParts[1]))
									{
										$sReturn = '';	
									}
								}
								else 
								{
									$sReturn = '';
								}
							}
						}			
						
						$sReturn = trim($sReturn, '/');
			
			$this->call('window.location.href = window.location.href;');// . AIN_Url::instance()->makeUrl($sReturn) . '\';');
		}
	}
	
	public function sample()
	{
		AIN::getBlock('language.sample');
	}

	public function loadMailPhrases()
	{
		$sLanguage = $this->get('sLanguage');
		AIN::getBlock('language.admincp.email', array('sLanguage' => $sLanguage));
		$this->html('#phrasesContainer', $this->getContent(false));
	}
}

?>