<?php

defined('AIN') or exit('NO DICE!');

class Language_Component_Block_Form extends AIN_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		$aLanguages = AIN::getService('language')->get();
		$aVals = $this->request()->getArray('val');		
		$bAddInput = false;		
		$bHasValue = false;
		if ($sMode = $this->getParam('mode'))
		{
		    $this->template()->assign(array('sMode' => $sMode));
		}
		
		if (($sVarName = $this->getParam('var_name')))
		{
			$aValues = AIN::getService('language.phrase')->getValues($sVarName);
			$bHasValue = true;
		}		
		
		
		
		
		
		if (($bHasValue === true) || (($aValues = $this->getParam('value')) !== null))
		{
			
			$bAddInput = true;			
			$aKeys = array_keys($aValues);
			$aVals2 = array_values($aValues);
			
			if (isset($aVals2[0]))
			{
				$aVals[$this->getParam('id')] = $aVals2[0];
			}
			
			$this->setParam('value', null);
		}		
		
		foreach ($aLanguages as $iKey => $aLanguage)
		{
			if ($bAddInput && isset($aKeys[0]))
			{
				$aLanguages[$iKey]['phrase_var_name'] = $aKeys[0];
			}
			$mPost = '';
			
			if (isset($aVals[$this->getParam('id')][$aLanguage['language_id']]))
			{
				if ($this->getParam('mode', '') != '')
				{		
					if (isset($aVals[$this->getParam('id')][$aLanguage['language_id']][$this->getParam('mode')]))
					$mPost = $aVals[$this->getParam('id')][$aLanguage['language_id']][$this->getParam('mode')];
					
					$this->template()->assign(array('sMode' => $this->getParam('mode')));;
				}
				if (isset($aVals[$this->getParam('id')][$aLanguage['language_id']]) 
					&& !empty($aVals[$this->getParam('id')][$aLanguage['language_id']])
					&& is_string($aVals[$this->getParam('id')][$aLanguage['language_id']]))
				{
				    
					$mPost = $aVals[$this->getParam('id')][$aLanguage['language_id']];
				}
				
			}
			$aLanguages[$iKey]['post_value'] = $mPost;
			
		}
		
		$this->template()->assign(array(
				'aLanguages' => $aLanguages,
				'sType' => $this->getParam('type'),
				'sId' => $this->getParam('id')
			)
		);
	}

	public function clean()
	{
		(($sPlugin = AIN_Plugin::get('language.component_block_admincp_form_clean')) ? eval($sPlugin) : false);		
	}
}

?>