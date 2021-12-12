<?php

defined('AIN') or exit('NO DICE!');

class Language_Service_Phrase_Phrase extends AIN_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('language_phrase');
	}
	
	public function isPhrase($aVals)
	{		
		$sPhrase = AIN::getService('language.phrase.process')->prepare($aVals['var_name']);		
		$aParts = explode('|', $aVals['module']);				
		
		$aRow = $this->database()->select('lp.var_name, lp.module_id AS name')
			->from($this->_sTable, 'lp')
			->where("lp.module_id = '" . $this->database()->escape($aParts[0]) . "' AND lp.var_name = '" . $this->database()->escape($sPhrase) . "'")
			->execute('getRow');

		if (!isset($aRow['var_name']))
		{
			return false;
		}
		
		return $aParts[1] . '.' . $sPhrase;
	}
	public function get($aConds = array(), $sSort = 'lp.phrase_id DESC', $iPage = '', $sLimit = '', $bCount = true)
	{		
		$iCnt = ($bCount ? 0 : 1);
		$aRows = array();
		
		if ($bCount)
		{			
			$iCnt = $this->database()->select('COUNT(*)')
				->from($this->_sTable, 'lp')
				->join(AIN::getT('language'), 'l', 'l.language_id = lp.language_id')
				->where($aConds)
				->execute('getField');
		}

		if ($iCnt)
		{
			$aRows = $this->database()->select('lp.*, lp.module_id AS name, l.title')
				->from($this->_sTable, 'lp')
				->join(AIN::getT('language'), 'l', 'l.language_id = lp.language_id')
				->where($aConds)
				->order($sSort)
				->limit($iPage, $sLimit, $iCnt)
				->execute('getRows');			
		}		
		
		if (!$bCount)
		{
			return $aRows;
		}
		
		return array($iCnt, $aRows);
	}
	public function getValues($sVarName)
	{
		$aParts = explode('.', $sVarName);
		
		$aPhrases = $this->database()->select('language_id, text')
			->from(AIN::getT('language_phrase'))
			->where('module_id = \'' . $this->database()->escape($aParts[0]) . '\' AND var_name = \'' . $this->database()->escape($aParts[1]) . '\'')
			->execute('getSlaveRows');		
		
		$aGroup = array();
		foreach ($aPhrases as $aPhrase)
		{
			$aGroup[$sVarName][$aPhrase['language_id']] = $aPhrase['text'];
		}		

		return $aGroup;	
	}
		
}
?>