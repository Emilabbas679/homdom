<?php

defined('AIN') or exit('NO DICE!');

class Core_Service_Currency_Currency extends AIN_Service 
{
	/**
	 * ARRAY of all the currencies
	 *
	 * @var array
	 */
	private $_aCurrencies = array();
	
	private $_sDefault = null;
	
	/**
	 * Class constructor
	 */	
	public function __construct()
	{	
		$this->_sTable = AIN::getT('currency');

		$sCacheId = $this->cache()->set('currency');
		if (!($this->_aCurrencies = $this->cache()->get($sCacheId)))
		{
			$aRows = $this->database()->select('*')
				->from(AIN::getT('currency'))
				->where('is_active = 1')
				->order('ordering ASC')
				->execute('getRows');
				
			foreach ($aRows as $aRow)
			{
				$this->_aCurrencies[$aRow['currency_id']] = array(
					'symbol' => $aRow['symbol'],
					'name' => $aRow['phrase_var'],
					'is_default' => $aRow['is_default']
				);
			}
			
			$this->cache()->save($sCacheId, $this->_aCurrencies);
		}		
	}
	public function get()
	{
		return $this->_aCurrencies;
	}
	
	
	
}

?>