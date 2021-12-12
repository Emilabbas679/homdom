<?php

defined('AIN') or exit('NO DICE!');

class Core_Service_device_device extends AIN_Service 
{
	private $_aDevices = array();	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('core_device');
		
		$sCachedId = $this->cache()->set('device_' . AIN::getLib('locale')->getLangId());
		if (!($this->_aDevices = $this->cache()->get($sCachedId)))
		{
			$aRows = $this->database()->select('core_device.id, core_device.name')
				->from($this->_sTable, 'core_device')				
				->order('core_device.name ASC')
				->execute('getRows');			
			
			foreach ($aRows as $aRow)
			{
				$this->_aDevices[$aRow['id']] = $aRow['name'];
			}		
			
			$this->cache()->save($sCachedId, $this->_aDevices);
		}
	}
	public function getDevice($id)
	{		
		return (isset($this->_aDevices[$id]) ? $this->_aDevices[$id] : false);
	}	
	public function get()
	{	
	
		return $this->_aDevices;
	}
}
?>