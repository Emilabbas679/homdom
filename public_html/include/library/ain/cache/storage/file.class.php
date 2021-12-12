<?php

defined('AIN') or exit('NO DICE!');

class AIN_Cache_Storage_File extends AIN_Cache_Abstract
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
	
	/**
	 * Sets the name of the cache.
	 *
	 * @param string $sName Unique fill name of the cache.
	 * @param string $sGroup Optional param to identify what group the cache file belongs to
	 * @return string Returns the unique ID of the file name
	 */
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
	
	/**
	 * By default we always close a cache call automatically, however at times
	 * you may need to close it at a later time and setting this to true will
	 * skip closing the closing of the cache reference.
	 *
	 * @param bool $bClose True to skip the closing of the connection
	 * @return object Returns the classes object.
	 */
	public function skipClose($bClose)
	{
		$this->_bSkipClose = $bClose;		
		
		return $this;
	}
		
	/**
	 * We attempt to get the cache file. Also used within an IF conditional statment
	 * to check if the file has already been cached.
	 *
	 * @see self::set()
	 * @param string $sId Unique ID of the file we need to get. This is what is returned from when you use the set() method.
	 * @param int $iTime By default this is left blank, however you can identify how long a file should be cached before it needs to be updated in minutes.
	 * @return mixed If the file is cached we return the data. If the file is cached but emptry we return a true (bool). if the file has not been cached we return false (bool).
	 */
	public function get($sId, $iTime = 0)
	{
		(AIN_DEBUG ? AIN_Debug::start('cache') : false);

		if (!$this->isCached($sId, $iTime))
		{
			return false;
		}

		$aContent = require($this->_getName($this->_aName[$sId]));

		(AIN_DEBUG ? AIN_Debug::end('cache', array('namefile' => $this->_getName($this->_aName[$sId]))) : false);

		if (!is_array($aContent) && empty($aContent))
		{
			return true;
		}	
		
		if (is_array($aContent) && !count($aContent))
		{
			return true;
		}

		return $aContent;
	}
	
	/**
	 * Save data to the cache.
	 *
	 * @see self::set()
	 * @param string $sId Unique ID connecting to the cache file based by the method set()
	 * @param string $mContent Content you plan on saving to cache. Can be bools, strings, ints, objects, arrays etc...
	 */
	public function save($sId, $mContent)
	{
		if (defined('AIN_INSTALLER'))
		{
			return false;
		}

		if (is_object($mContent)) {
			$mContent = (array) $mContent;
		}

		$sContent = '<?php return ' . var_export($mContent, true) . ';';

		file_put_contents($this->_getName($this->_aName[$sId]), $sContent);

		return true;
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
	
	/**
	 * Removes cache file(s). 
	 *
	 * @param string $sName Name of the cache file we need to remove.
	 * @param string $sType Pass an optional command to execute a specific routine.
	 * @return bool Returns true if we were able to remove the cache file and false if the system was locked.
	 */
	public function remove($sName = null, $sType = '')
	{
		if (file_exists(AIN_DIR_CACHE . 'cache.lock'))
		{
			return false;
		}

		if ($sName === null)
		{
			foreach ($this->getAll() as $aFile)
			{
				if (file_exists(AIN_DIR_CACHE . $aFile['name']))
				{
					if (is_dir(AIN_DIR_CACHE . $aFile['name']))
					{
						AIN::getLib('file')->delete_directory(AIN_DIR_CACHE . $aFile['name']);
					}
					else 
					{
						unlink(AIN_DIR_CACHE . $aFile['name']);
					
						$this->removeInfo(AIN_DIR_CACHE . $aFile['name']);
					}
				}
			}						
			
			return true;
		}		
		
		switch($sType)
		{
			case 'substr':

				$sDir = AIN_DIR_CACHE . (is_array($sName) ? rtrim($sName[0], '/') . AIN_DS : str_replace('_', AIN_DS, $sName));
				if (!AIN_SAFE_MODE && !AIN_OPEN_BASE_DIR && !is_dir($sDir))
				{
					AIN::getLib('file')->mkdir($sDir, true, 0777);
				}
				$aFiles = AIN::getLib('file')->getFiles($sDir);
				foreach ($aFiles as $sFile)
				{
					if (is_dir($sDir . AIN_DS . $sFile))
					{
						AIN::getLib('file')->delete_directory($sDir . AIN_DS . $sFile);
					}
					else
					{
						@unlink($sDir . AIN_DS .$sFile);
					}
				}

				if (is_array($sName))
				{
					$sName[0] = rtrim($sName[0], '/');
					if ($sName[0] == 'feeds')
					{
						$sName[0] = $sName[0] . AIN_Locale::instance()->getLangId();
					}
					$sName = $sName[0] . AIN_DS . $sName[1];
				}
				$sName = $this->_getName($sName);
				if (file_exists($sName))
				{
					@unlink($sName);
				}
				break;
			case 'path':
				if (file_exists($sName)) {
					@unlink($sName);
				}
				break;
			default:
				if (is_array($sName))
				{
					$sName[0] = rtrim($sName[0], '/');
					$sName = $sName[0] . AIN_DS . $sName[1];
				}
				$sName = $this->_getName($sName);
				if (file_exists($sName)) {
					@unlink($sName);
				}
		}

		return true;
	}

	/**
	 * Checks if a file is cached or not.
	 *
	 * @param string $sId Unique ID of the cache file.
	 * @param string $iTime By default no timestamp check is done, howver you can pass an int to check how many minutes a file can be cached before it must be recached.
	 * @return bool Returns true if the file is cached and false if the file hasn't been cached already.
	 */
	public function isCached($sId, $iTime = 0)
	{
		if (AIN::getParam('core.cache_skip'))
		{
			return false;
		}

		if (isset($this->_aName[$sId]) && file_exists($this->_getName($this->_aName[$sId])))
		{
			if ($iTime && (AIN_TIME - $iTime * 60) > (filemtime($this->_getName($this->_aName[$sId]))))
			{
				$this->remove($this->_aName[$sId]);
				return false;
			}

			return true;
		}

		return false;
	}

	/**
	 * Gets all the cache files and returns information about the cache file to stats.
	 *
	 * @param array $aConds SQL conditions (not used anymore)
	 * @param string $sSort Sorting the cache files
	 * @param int $iPage Current page we are on
	 * @param string $sLimit Limit of how many files to display
	 * @return array First array is how many cache files there are and the 2nd array holds all the cache files.
	 */
	public function getCachedFiles($aConds = array(), $sSort, $iPage, $sLimit)
	{
		$iCnt = 0;
		$aRows = array();
		$iSize = 0;
		$aFiles = AIN::getLib('file')->getAllFiles(AIN_DIR_CACHE, true);
		$iLastFile = 0;
		foreach ($aFiles as $sFile)
		{
			$iSize += filesize($sFile);
			$iCnt++;

			if (filemtime($sFile) > $iLastFile)
			{
				$iLastFile = filemtime($sFile);
			}
		}

		$this->_aStats = array(
			'total' => $iCnt,
			'size' => $iSize,
			'last' => $iLastFile
		);

		return array($iCnt, $aRows);
	}

	/**
	 * Returns the full path to the cache file.
	 *
	 * @param string $sFile File name of the cache
	 * @return string Full path to the cache file.
	 */
	private function _getName($sFile)
	{
		if ($this->_getParam('free'))
		{
			return $sFile;
		}
		elseif ($this->_getParam('path'))
		{
			return $sFile;
		}

		$sPath = AIN_DIR_CACHE . (AIN::getParam('core.cache_add_salt') ? md5(AIN::getParam('core.salt') . $sFile) : $sFile) . AIN::getParam('core.cache_suffix');

		$aParts = pathinfo($sPath);
		$aSub = explode('_', $aParts['filename']);

		if (count($aSub) >= 1) {
			$sActualName = $aSub[count($aSub) - 1];
			unset($aSub[count($aSub) - 1]);
			$sDir = $aParts['dirname'] . '/' . implode('/', $aSub);
		}
		else {
			$sActualName = $sFile;
			$sDir = $aParts['dirname'] . '/';
		}
		// $sDir = $aParts['dirname'] . '/' . str_replace('_', '/', $aParts['filename']);
		if (!is_dir($sDir)) {
			mkdir($sDir, 0777, true);
		}
		$sNewPath = rtrim($sDir, '/') . '/' . $sActualName . '.php';
		return $sNewPath;
	}
}