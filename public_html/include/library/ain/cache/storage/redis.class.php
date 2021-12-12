<?php

defined('AIN') or exit('NO DICE!');

class AIN_Cache_Storage_Redis extends AIN_Cache_Abstract
{
	/**
	 * Array of all the cache files we have saved.
	 *
	 * @var array
	 */
	private $_aName = array();	
	
	/**
	 * Name of the current cache file we are saving
	 *
	 * @var string
	 */
	private $_sName;
	
	/**
	 * Set this to true and we will force the system to get the information from
	 * a memory based caching system (eg. memcached)
	 *
	 * @var bool
	 */
	private $_bFromMemory = false;
	
	/**
	 * By default we always close a cache call automatically, however at times
	 * you may need to close it at a later time and setting this to true will
	 * skip closing the closing of the cache reference.
	 *
	 * @var bool
	 */
	private $_bSkipClose = false;
	
	
	private $_client;
	
	/**
	 * We open up a connection to each of the memcached servers.
	 *
	 */
	public function __construct()
	{	
		$this->_client = new Redis();
		$this->_client->connect('127.0.0.1', 6379); 
	}
	public function redis()
	{
		return $this->_client;
	}
	public function set($sName, $sGroup = '')
	{		
		if (is_array($sName))
		{
			if (AIN_SAFE_MODE || AIN_OPEN_BASE_DIR)
			{
				$sName = str_replace(array('/', AIN_DS), '_', $sName[0]) . '_' . $sName[1];
			}
			else
			{
				$sName = rtrim($sName[0], '/') . AIN_DS . $sName[1];
			}
		}
		
		$sId = $sName;
		
		$this->_aName[$sId] = $sName;
		$this->_sName = $sName;
		
		if ($sGroup == 'memory')
		{
			$this->_bFromMemory = true;	
		}		
		
		return $sId;
	}		
	public function skipClose($bClose)
	{
		$this->_bSkipClose = $bClose;		
		
		return $this;
	}	
	private function _getName($sFile)
	{
		if (defined('AIN_IS_HOSTED_SCRIPT'))
		{
			$sFile = md5($this->_getHashId() . $sFile);
		}		
		
		return $sFile;
	}
	/**
	 * Close the cache connection.
	 *
	 * @param string $sId ID of the cache file we plan on closing the connection with.
	 */
	public function close($sId)
	{
		unset($this->_aName[$sId]);		
	}
	private function _getHashId()
	{
		$sName = md5('oncloudsite' . AIN_IS_HOSTED_SCRIPT);
		$sHashKey = $this->_client->get($sName);
		if (empty($sHashKey))
		{
			$sHashKey = AIN_IS_HOSTED_SCRIPT . uniqid();
			$this->_client->set(md5('oncloudsite' . AIN_IS_HOSTED_SCRIPT), $sHashKey);
		}

		return $sHashKey;
	}
	public function get($sId, $iTime = 0)
	{
		if ($this->_bFromMemory)
		{
			$this->_bFromMemory = false;
			
			return false;
		}	
		if (AIN::getParam('core.cache_skip'))
		{
			return false;
		}		
		if (!$this->_client->exists($this->_getName($this->_aName[$sId]))) {
			return false;
		}		
		
		if (!($sContent = $this->_client->get($this->_getName($this->_aName[$sId]))))
		{			
			return false;
		}
		
		
		return json_decode($sContent, true);
	}
	
	
	
	
	
	
	
	public function remove($name = null) {
		if ($name === null) {
			$this->_client->flushall();
			return;
		}
		$this->_client->del($name);
	}	

	public function save($name, $value) {
		$this->_client->set($name, json_encode($value));
	}

	
	
	
	
	public function getCachedFiles($aConds = array(), $sSort, $iPage, $sLimit)
	{
	
	
	}
	
}