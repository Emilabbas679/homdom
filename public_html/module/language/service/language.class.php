<?php


defined('AIN') or exit('NO DICE!');

class Language_Service_Language extends AIN_Service 
{
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('language');
	}
	
	public function getForAdminCp($aConds = array())
	{
		$aRows = $this->database()->select('l.*')
			->from($this->_sTable, 'l')
			->where($aConds)
			->order('l.is_default DESC, l.title')
			->execute('getSlaveRows');						
		
		return $aRows;
	}	
	public function get($aConds = array())
	{
		$sCacheId = $this->cache()->set(array('locale', 'language_table_' . md5((is_array($aConds) ? implode('', $aConds) : $aConds))));
		if (!($aRows = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('l.*')
				->from($this->_sTable, 'l')
				->where($aConds)
				->order('l.is_default DESC, l.title')
				->execute('getSlaveRows');		
				
			foreach ($aRows as $iKey => $aRow)
			{

			}
				
			$this->cache()->save($sCacheId, $aRows);
		}
		
		$this->database()->clean();
		
		return $aRows;
	}
	public function getAll()
	{
		return $this->database()->select('*')
			->from(AIN::getT('language'))
			->execute('getRows');
	}
	public function getLanguage($iId)
	{		
		$aRow = $this->database()->select('l.*')
			->from($this->_sTable, 'l')
			->where('l.language_id = \'' . $this->database()->escape($iId) . '\'')
			->execute('getSlaveRow');
			
		if (!isset($aRow['language_id']))
		{
			return false;
		}
			
			
		return $aRow;
	}
	
	
	
	
	
	
	
	
	
}
?>