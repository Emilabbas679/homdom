<?php

defined('AIN') or exit('NO DICE!');

class AIN_Cdn_Module_AIN extends AIN_Cdn_Abstract
{	
	private $_iServerId = 0;
	private $_aServers = array();
	
	public function __construct()
	{
		if (!file_exists(AIN_DIR_SETTING . 'cdn.sett.php'))
		{
			AIN_Error::trigger('CDN setting file is missing.', E_USER_DEPRECATED);
		}
		
		require_once(AIN_DIR_SETTING . 'cdn.sett.php');
		
		foreach ($aServers as $iKey => $aServer)
		{
			//$iKey++;
			//$iKey++;
			$this->_aServers[$iKey] = $aServer;
		}	
				
		
	}
	public function setServerId($iServerId)
	{
		$this->_iServerId = $iServerId;
	}
	public function getServerId()
	{
		return $this->_iServerId;		
	}
	/**
	 * Uploads the file to amazons server.
	 *
	 * @param string $sFile Full path to where the file is located.
	 * @param string $sName Optional name of the file once it is uploaded. By default we just use the original file name.
	 * @return bool We only return a bool false if we were not able to upload the item.
	 */
	public function put($sFile, $sName = null)
	{
		if (empty($sName))
		{
			$sName = str_replace("\\", '/', str_replace(AIN_DIR, '', $sFile));
		}
		$aPost = array(
			'file_name' => $sName,
			'upload' => '@' . $sFile . '',
			'action' => 'upload',
			'cdn_key' => $this->_aServers[$this->_iServerId]['key']
		);
		
		$mReturn = $this->_send($aPost);		
		
		$mReturn = json_decode($mReturn, true);			
		
		if (function_exists('json_last_error') && json_last_error() != JSON_ERROR_NONE)
		{
			AIN_Error::set('Unable to connect to CDN server.');
			
			return false;
		}
		
		return $mReturn;
	}
	
	private function _send($aPost, $bIsDelete = false)
	{
		$hCurl = curl_init();

		curl_setopt($hCurl, CURLOPT_URL, rtrim($this->_aServers[$this->_iServerId]['upload'], '/'));
		curl_setopt($hCurl, CURLOPT_HEADER, false);
		curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, true);			

		curl_setopt($hCurl, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($hCurl, CURLOPT_POST, true);
		
		// https://github.com/sendgrid/sendgrid-php/issues/38
		if(!$bIsDelete && defined('PHP_VERSION_ID') && PHP_VERSION_ID > 50500)
		{
			$sMIME = null;
			$sFileName = substr($aPost['upload'], 1);
			
			
			
			if(function_exists('mime_content_type'))
			{
				$sMIME = mime_content_type($sFileName);
			}
			else
			{
				$hFileInfo = finfo_open(FILEINFO_MIME_TYPE);
				$sMIME = finfo_file($hFileInfo, $sFileName);
				finfo_close($hFileInfo);
			}
			$aPost['upload'] = new CurlFile($sFileName, $sMIME, $sFileName);
		}
		
		curl_setopt($hCurl, CURLOPT_POSTFIELDS, $aPost);

		$mReturn = curl_exec($hCurl);				
		
		curl_close($hCurl);		
		
		return $mReturn;
	}
	public function getUrl($sPath, $iServerId = null, $bBass = false)
	{		
		$sPath = str_replace(AIN::getParam('core.path'), '', $sPath);
		$sPath = str_replace("\\", '/', $sPath);

		
		if ($iServerId == null)
        {
            $iServerId = $this->getServerId();
        }
		
		if (!isset($this->_aServers[$iServerId]))
		{
			return '';
		}
		
		return $this->_aServers[$iServerId]['url'] . $sPath;
	}
	public function remove($sFile)
	{
		$sName = str_replace("\\", '/', str_replace(AIN_DIR, '', $sFile));
		
		$aPost = array(
			'file_name' => $sName,
			'action' => 'remove',
			'cdn_key' => $this->_aServers[$this->_iServerId]['key']
		);
		
		$mReturn = $this->_send($aPost, true);
		
		$mReturn = json_decode($mReturn, true);			
		
		if (function_exists('json_last_error') && json_last_error() != JSON_ERROR_NONE)
		{
			AIN_Error::set('Unable to connect to CDN server.');
			
			return false;
		}			
		return true;
	}
}
?>