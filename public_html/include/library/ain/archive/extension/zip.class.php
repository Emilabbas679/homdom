<?php

defined('AIN') or exit('NO DICE!');

class AIN_Archive_Extension_Zip
{
	/**
	 * Object of the PHP class ZipArchive
	 *
	 * @var object
	 */
	private $_oZip = null;
	
	/**
	 * Constructor
	 *
	 */	
	public function __construct()
	{			
		if (class_exists('ZipArchive'))
		{
			$this->_oZip = new ZipArchive;
		}		
	}
	/**
	 * Test if the server has support for working with tar.gz files
	 *
	 * @return bool True if support is there | False if no support for tar.gz files
	 */	
	public function test()
	{
		return (((is_object($this->_oZip)) || (!AIN_SAFE_MODE)) ? true : false);
	}
	/**
	 * Compress data into the archive
	 *
	 * @param string $sFile Name of the ZIP file
	 * @param string $sFolder Name of the folder we are going to compress. Must be located within the "file/cache/" folder.
	 * @return mixed Returns the full path to the newly created ZIP file.
	 */	
	public function compress($sFile, $sFolder)
	{		
		// Create random ZIP
		$sArchive = AIN_DIR_CACHE . md5((is_array($sFile) ? serialize($sFile) : $sFile) . AIN::getParam('core.salt') . AIN_TIME) . '.zip';
		
		chdir(AIN_DIR_CACHE . $sFolder . AIN_DS);
		
		if (is_object($this->_oZip))
		{			
			if ($this->_oZip->open($sArchive, ZipArchive::CREATE))
			{
				$aFiles = AIN_File::instance()->getAllFiles(AIN_DIR_CACHE . $sFolder . AIN_DS);
				
				foreach ($aFiles as $sNewFile)
				{
					$sNewFile = str_replace(AIN_DIR_CACHE . $sFolder . AIN_DS, '', $sNewFile);

					$this->_oZip->addFile($sNewFile);	
				}				
				
	    		$this->_oZip->close();    			    	
			}		
		}
		else 
		{	
			shell_exec(AIN::getParam('core.zip_path') . ' -r ' . escapeshellarg($sArchive) . ' ./');			
		}	
		
		chdir(AIN_DIR);
		
		return $sArchive;
	}
	/**
	 * Extracts data from the archive
	 *
	 * @param string $sFile Full path to the archive
	 * @param string $sLocation Final location of where to place the extracted content
	 */	
	public function extract($sFile, $sLocation)
	{		
		if (is_object($this->_oZip))
		{
			if ($this->_oZip->open($sFile))
			{	
				$this->_oZip->extractTo($sLocation);				
			    $this->_oZip->close();			    
			    return true;		
			}
		}
		else 
		{
			shell_exec(AIN::getParam('core.unzip_path') . ' -u ' . escapeshellarg($sFile) . ' -d ' . escapeshellarg($sLocation) . '');		
			
			return true;	
		}
		
		return false;
	}
}
?>