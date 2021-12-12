<?php

defined('AIN') or exit('NO DICE!');

class Core_service_Rewrite extends AIN_Service
{	
	
	public function getRewrite($sUrls)
	{
		return AIN::getLib('database')->select('controller')->from(AIN::getT('core_rewrite'))->where('url = "'.$sUrls.'"')->execute('getRow');
	}
	public function setRewrite($controller, $sUrls)
	{
		$isCheck = AIN::getLib('database')->select('controller')->from(AIN::getT('core_rewrite'))->where('url = "'.$sUrls.'"')->execute('getRow');

		if( ! isset($isCheck['controller']) )
		{			
			return AIN::getLib('database')->insert(AIN::getT('core_rewrite'), array('url' => $sUrls, 'controller' => $controller ) );
		}
		else
		{
			return false;
		}		
	}
	
	
}
?>