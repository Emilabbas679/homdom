<?php

defined('AIN') or exit('NO DICE!');

class Language_Service_Phrase_Process extends AIN_Service 
{
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('language_phrase');		
	}
	
	public function update($iId, $sText, $aExtra = array())
	{
		$aUpdate = array(
			//'text' => AIN::getLib('parse.input')->convert($sText)
			'text' => $sText
		);
		
		if ($aExtra)
		{
			$aUpdate = array_merge($aUpdate, $aExtra);
		}		
		
		$this->database()->update($this->_sTable, $aUpdate, 'phrase_id = ' . (int) $iId);
		
		$this->cache()->remove('language', 'substr');
		
		return true;
	}

	public function prepare($sText)
	{
		static $aCache = array();
		
		if (isset($aCache[$sText]))
		{
			return $aCache[$sText];
		}
		
		$sText = trim($sText);	
		
		$sPhrase = $sText;
		
		$aCache[$sText] = strtolower(preg_replace('/ +/', '-', preg_replace('/[^0-9a-zA-Z]+/', '_', $sPhrase)));
		
		$aCache[$sText] = trim($aCache[$sText], '_');	
		
		if (empty($aCache[$sText]))
		{
			$aCache[$sText] = uniqid();
		}			
				
		return $aCache[$sText];
	}
	public function add($aVals, $bClean = false)
	{	
		$sPhrase = $this->prepare($aVals['var_name']);
		$oParseInput = AIN::getLib('parse.input');

		
		if (isset($aVals['module']))
		{
			$aParts = explode('|', $aVals['module']);
		}		
		
		foreach ($aVals['text'] as $iId => $sText)
		{
			$sText = trim($sText);
			
			if (empty($sText))
			{
				$sText = $aVals['text']['az'];
				// continue;
			}
			
			if ($bClean === true)
			{
				$sText = $oParseInput->clean($sText);
			}
			else 
			{
				$sText = $oParseInput->convert($sText);
			}			
			
			
			
			$this->database()->insert($this->_sTable, array(
					'language_id' => $iId,
					'module_id' => (isset($aParts) ? $aParts[0] : 'core'),
					'var_name' => $sPhrase,
					'text' => $sText,
					'text_default' => $sText,
					'added' => AIN_TIME
				)
			);
			
		}
		
		
		$sFinalPhrase = (isset($aVals['module']) ? $aParts[1] . '.' . $sPhrase : $sPhrase);
		
		$this->cache()->remove('locale', 'substr');
		
		return $sFinalPhrase;
	}
	public function importPhrases($sLanguageId, $iPage = 0, $iLimit = 500)
	{		
		$aLanguage = $this->database()->select('*')
			->from(AIN::getT('language'))
			->where('language_id = \'' . $this->database()->escape($sLanguageId) . '\'')
			->execute('getRow');
			
		if (!isset($aLanguage['language_id']))
		{
			return AIN_Error::set(AIN::getPhrase('language.language_package_not_found'));
		}	
		
		$iCnt = $this->database()->select('COUNT(*)')
			->from(AIN::getT('language_phrase'))
			->where('language_id = \'' . $this->database()->escape($aLanguage['parent_id']) . '\'')
			->execute('getField');	
		
		if (!$iCnt)
		{
			return false;
		}
		
		$aParentPhrases = $this->database()->select('*')
			->from(AIN::getT('language_phrase'))
			->where('language_id = \'' . $this->database()->escape($aLanguage['parent_id']) . '\'')
			->limit($iPage, $iLimit, $iCnt)
			->order('phrase_id ASC')
			->execute('getRows');
		foreach ($aParentPhrases as $aParentPhrase)
		{
			$aInsert = array();
			foreach ($aParentPhrase as $sKey => $sValue)
			{
				if ($sKey == 'phrase_id')
				{
					continue;
				}
				
				if ($sKey == 'language_id')
				{
					$sValue = $sLanguageId;
				}
				
				$aInsert[$sKey] = $sValue;
			}

			$this->database()->insert(AIN::getT('language_phrase'), $aInsert);
		}		
		
		return $iCnt;
	}
	
	public function delete($iId)
	{
		$this->database()->delete($this->_sTable, 'phrase_id = ' . (int) $iId);
		
		$this->cache()->remove('locale', 'substr');
		
		return true;
	}	

	
	
}

?>