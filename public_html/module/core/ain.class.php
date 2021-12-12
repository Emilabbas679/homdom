<?php

defined('AIN') or exit('NO DICE!');

class Module_Core 
{	
	public static $aTables = array(
		'core_rewrite',
	);
	
	public static $aInstallWritable = array(
		'file/cache/',
	);
}

?>