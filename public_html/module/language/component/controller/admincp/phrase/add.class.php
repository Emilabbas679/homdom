<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Controller_Admincp_Phrase_Add extends AIN_Component 
{
	/**
	 * Controller
	 */
	public function process()
	{
		AIN::getUserParam('language.can_manage_lang_packs', true);
		
		$aModules = AIN::getLib('module')->getModules();
		$aLanguages = AIN::getService('language')->get();
		
		
		
		$aValidation = array();				
		$oValid = AIN::getLib('validator')->set(array('sFormName' => 'js_phrase_form', 'aParams' => $aValidation));
		
		
		if ($aVals = $this->request()->getArray('val'))
		{
			if (empty($aVals['var_name']) && isset($aVals['text']['az']))
			{
				$aVals['var_name'] = $aVals['text']['az'];
			}
				
			if (empty($aVals['var_name']))
			{
				AIN_Error::set(AIN::getPhrase('language.provide_a_var_name_dot'));
			}
			// Check that all the fields are valid
			if ($oValid->isValid($aVals))
			{
				// Check to make sure the phrase has not already been added
				if (($sIsPhrase = AIN::getService('language.phrase')->isPhrase($aVals)))
				{					
					AIN_Error::set(AIN::getPhrase('language.phrase_already_created', array('phrase' => $sIsPhrase)) . ' - ' . AIN::getPhrase($sIsPhrase));	
					
					$sCachePhrase = $sIsPhrase;
				}
				else 
				{
					
					$sVarName = AIN::getService('language.phrase.process')->prepare($aVals['var_name']);
					
					
					if (isset($aVals['module']))
					{
						$aParts = explode('|', $aVals['module']);
						$sVarName = $aParts[0] . '.' . $sVarName;
					}		
						
					$sCached = AIN::getPhrase('language.phrase_added', array('phrase' => $sVarName));
					
					$sPhrase = AIN::getService('language.phrase.process')->add($aVals);
					
					// Verify if we have a return URL, if we do send them there instead
					if (($sReturn = $this->request()->get('return')))
					{				
						$this->url()->forward($sReturn, $sCached);
					}
					else 
					{				
						AIN::getLib('session')->set('cache_new_phrase', $sVarName);
						
						$this->url()->send('language.phrase.add', array('last-module' => $aParts[1]), $sCached);
					}
				}
			}
		}
		if (!isset($sCachePhrase) && ($sCachePhrase = AIN::getLib('session')->get('cache_new_phrase')))
		{
			AIN::getLib('session')->remove('cache_new_phrase');
		}	
		
		
		
		
		// Assign needed vars to the template
		$this->template()->assign(array(
			'aModules' => $aModules,
			'aLanguages' => $aLanguages,
			'sCachePhrase' => (isset($sCachePhrase) ? $sCachePhrase : ''),
		));
			
		
		
	}
}
?>	