<?php

defined('AIN') or exit('NO DICE!');

class AIN_Api
{	
	/**
	 * Error message.
	 *
	 * @var string
	 */
	private $_sError = '';


	/**
	 * Echo a public message. Used when the site is being upgraded or hasn't been installed.
	 *
	 * @param string $sStr Message to echo.
	 */
	public function message($sStr)
	{
		$sMessage = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
		$sMessage .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en">';
		$sMessage .= '<head><title>AIN</title><meta http-equiv="Content-Type" content="text/html;charset=utf-8" /><style type="text/css">body{font-family:verdana; color:#000; font-size:11px; margin:5px; background:#fff;} img{border:0px;}</style></head><body>';
		$sMessage .= '</div>';
		$sMessage .= '<div style="padding:4px; font-size:11pt;">' . $sStr . '</div>';
		$sMessage .= '</body></html>';		
		
		echo $sMessage;
		
		exit;	
	}

	
	
	
	
	
	
}
?>