<?php

defined('AIN') or exit('NO DICE!');

class AIN_Archive
{
	private $_oObject = null;

	public function __construct($sExt = null)
	{
		if ($sExt)
		{
			switch ($sExt)
			{
				case 'zip':
					$sObject = 'archive.extension.zip';
					break;
				case 'tar.gz':
					$sObject = 'archive.extension.tar';
					break;		
				case 'xml':
					$sObject = 'archive.extension.xml';
					break;	
				default:
					if (substr($sExt, -4) == '.zip')
					{
						$sObject = 'archive.extension.zip';
					}
			}		
			(($sPlugin = AIN_Plugin::get('archive__construct')) ? eval($sPlugin) : false);
		
			$this->_oObject = AIN::getLib($sObject);
		}
	}
	public function &getInstance()
	{
		return $this->_oObject;
	}
}

?>