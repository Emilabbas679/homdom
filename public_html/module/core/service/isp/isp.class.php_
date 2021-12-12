<?php

defined('AIN') or exit('NO DICE!');

class Core_Service_isp_isp extends AIN_Service 
{
	private $_mobilebrand = array();	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('core_isp');
		
		$sCachedId = $this->cache()->set('mobilebrand_' . AIN::getLib('locale')->getLangId());
		if (!($this->_mobilebrand = $this->cache()->get($sCachedId)))
		{
			$aRows = $this->database()->select('core_isp.id, core_isp.name, core_isp.mobilebrand')
				->from($this->_sTable, 'core_isp')				
				->order('core_isp.name ASC')
				->execute('getRows');			
			
			foreach ($aRows as $aRow)
			{
				$this->_mobilebrand[$aRow['mobilebrand']] = $aRow['id'];
			}		
			
			$this->cache()->save($sCachedId, $this->_mobilebrand);
		}		
		$sCachedId = $this->cache()->set('usage_isp_' . AIN::getLib('locale')->getLangId());
		if (!($this->_isp = $this->cache()->get($sCachedId)))
		{
			$aRows = $this->database()->select('core_isp.id, core_isp.name, core_isp.mobilebrand')
				->from($this->_sTable, 'core_isp')				
				->order('core_isp.name ASC')
				->execute('getRows');			
			
			foreach ($aRows as $aRow)
			{
				$this->_isp[$aRow['id']] = $aRow['name'];
			}		
			
			$this->cache()->save($sCachedId, $this->_isp);
		}
	}
	public function mobilebrand($id)
	{		
		return (isset($this->_mobilebrand[$id]) ? $this->_mobilebrand[$id] : 0);
	}		
	public function get()
	{		
		return $this->_isp;
	}
	
	
	
	
	
	
	
	
	
	
	
	public function reLoad()
	{
		$aRows = $this->database()->select(' DISTINCT ads_log.mobileCarrierName, ads_log.isp,  ads_log.country_iso,  ads_log.usageType')
			->from(AIN::getT('ads_log'), 'ads_log')		
			->where('ads_log.mobileCarrierName != "-" and ads_log.usageType = "MOB"')
			->group('ads_log.mobileCarrierName, ads_log.isp,  ads_log.country_iso')			
			->limit(0,10)
			->execute('getRows');	
		
			foreach($aRows as $key => $row )	
			{
	
	
			}			
				
				
		
	}
}
?>