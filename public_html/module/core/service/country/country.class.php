<?php

defined('AIN') or exit('NO DICE!');

class Core_Service_Country_Country extends AIN_Service 
{
	private $_aCountries = array();	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('core_country');
		
		$sCachedId = $this->cache()->set('country_' . AIN::getLib('locale')->getLangId());
		if (!($this->_aCountries = $this->cache()->get($sCachedId)))
		{
			$aRows = $this->database()->select('c.country_iso, c.name')
				->from($this->_sTable, 'c')				
				->order('c.ordering ASC, c.name ASC')
				->execute('getRows');			
			foreach ($aRows as $aRow)
			{
				$this->_aCountries[$aRow['country_iso']] = (AIN::getLib('locale')->isPhrase('core.translate_country_iso_' . strtolower($aRow['country_iso'])) ? AIN::getPhrase('core.translate_country_iso_' . strtolower($aRow['country_iso'])) : $aRow['name']);
			}					
			
			$this->cache()->save($sCachedId, $this->_aCountries);
		}
	}
	public function getCountry($sIso)
	{		
		return (isset($this->_aCountries[$sIso]) ? $this->_aCountries[$sIso] : false);
	}
	
	public function get()
	{	
		return $this->_aCountries;
	}
}
?>