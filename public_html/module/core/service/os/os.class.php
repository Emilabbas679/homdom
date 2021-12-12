<?php

defined('AIN') or exit('NO DICE!');

class Core_Service_os_os extends AIN_Service 
{
	private $_aoss = array();	
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('core_os');
		
		$sCachedId = $this->cache()->set('os_' . AIN::getLib('locale')->getLangId());
		if (!($this->_aoss = $this->cache()->get($sCachedId)))
		{
			$aRows = $this->database()->select('core_os.id, core_os.name')
				->from($this->_sTable, 'core_os')				
				->order('core_os.name ASC')
				->execute('getRows');			
			
			foreach ($aRows as $aRow)
			{
				$this->_aoss[$aRow['id']] = $aRow['name'];
			}		
			
			$this->cache()->save($sCachedId, $this->_aoss);
		}
	}
	public function getos($id)
	{		
		return (isset($this->_aoss[$id]) ? $this->_aoss[$id] : false);
	}	
	public function get()
	{	
	
		return $this->_aoss;
	}
}
?>