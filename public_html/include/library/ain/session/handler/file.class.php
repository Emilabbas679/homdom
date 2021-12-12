<?php

defined('AIN') or exit('NO DICE!');


class AIN_Session_Handler_File
{
	/**
	 * Path to save a session.
	 *
	 * @var string
	 */
	private $_sSavePath = '';
	
	/**
	 * Session prefix.
	 *
	 * @var string
	 */
	private $_sPrefix = 'sess_';
	
	/**
	 * Start the session.
	 *
	 * @return mixed NULL if no errors, however FALSE if session cannot start.
	 */
	public function init()
	{		
		session_set_save_handler(
				array($this, 'open'),
				array($this, 'close'),
				array($this, 'read'),
				array($this, 'write'),
				array($this, 'destroy'),
				array($this, 'gc')			
		);		
		
		if (AIN_SAFE_MODE)
		{
			$this->_sSavePath = AIN_DIR_CACHE;	
		}
		else 
		{
			$sSessionSavePath = (AIN_OPEN_BASE_DIR ? AIN_DIR_FILE . 'session' . AIN_DS : session_save_path());
			
			if (empty($sSessionSavePath) || (!empty($sSessionSavePath) && !AIN::getLib('file')->isWritable($sSessionSavePath)))
			{
				$this->_sSavePath = rtrim(AIN::getLib('file')->getTempDir(), AIN_DS) . AIN_DS;
			}
			else 
			{
				$this->_sSavePath = rtrim($sSessionSavePath, AIN_DS) . AIN_DS;
			}
		}
		
		if (!AIN::getLib('file')->isWritable($this->_sSavePath))
		{
			return AIN_Error::trigger('Session path is not wriable: ' . $this->_sSavePath, E_USER_ERROR);
		}
		
		if(!isset($_SESSION))
		{
			session_start();	
		}
	}
	
	/**
	 * Open a session file.
	 *
	 * @return bool Always TRUE.
	 */
	public function open()
	{	  
		return true;
	}
	
	/**
	 * Close a session file.
	 *
	 * @return bool Always TRUE.
	 */
	public function close()
	{
		return true;
	}
	
	/**
	 * Read a session file.
	 *
	 * @param int $iId File ID.
	 * @return mixed FALSE if not exists, STRING if file exists.
	 */
	public function read($iId)
	{
		if (!file_exists($this->_sSavePath . $this->_sPrefix . $iId))
		{
			return false;
		}
		
		return (string) file_get_contents($this->_sSavePath . $this->_sPrefix . $iId);
	}
	
	/**
	 * Write to session file.
	 *
	 * @param int $iId Session ID.
	 * @param string $mData Session Data.
	 * @return bool TRUE if success, FALSE on failure.
	 */
	public function write($iId, $mData)
	{  	  
		if ($hFp = @fopen($this->_sSavePath . $this->_sPrefix . $iId, "w")) 
		{
	    	$bReturn = fwrite($hFp, $mData);
	    	fclose($hFp);
	    	
	    	return $bReturn;
	  	} 
	  	else 
	  	{
	    	return(false);
	  	}	
	}
	
	/**
	 * Remove session file.
	 *
	 * @param int $iId Session ID.
	 * @return bool TRUE on success, FALSE on failure.
	 */
	public function destroy($iId)
	{
		return(@unlink($this->_sSavePath . $this->_sPrefix . $iId));
	}
	
	/**
	 * Garbage collecting.
	 *
	 * @param int $iMaxLifetime Define how long a session can exist on the server.
	 * @return bool Always TRUE.
	 */
	public function gc($iMaxLifetime)
	{
		AIN_Error::skip(true);
		foreach (glob($this->_sSavePath . $this->_sPrefix . '*') as $sFilename) 
		{
	    	if (filemtime($sFilename) + $iMaxLifetime < time()) 
	    	{
	      		@unlink($sFilename);
	    	}
	  	}
		AIN_Error::skip(false);
	  	return true;
	}	
}

?>