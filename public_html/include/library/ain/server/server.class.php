<?php

defined('AIN') or exit('NO DICE!');

class AIN_Server
{
	/**
	 * Check to see if we are on a windows server.
	 *
	 * @return bool TRUE if windows, FALSE if not.
	 */
	public function isWindows()
	{
		return (PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows');
	}		
	
	/**
	 * Return the server URL based on the server ID (load balancing).
	 *
	 * @param int $sId Server ID.
	 * @return string Server URL.
	 */
	public function getServerUrl($sId)
	{
		$aServers = AIN::getParam(array('balancer', 'servers'));
		foreach ($aServers as $iIp => $aServer)
		{
			if ($aServer['id'] == $sId)
			{
				return $aServer['url'];		
			}		
		}		
	}
}

?>
