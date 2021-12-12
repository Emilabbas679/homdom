<?php

defined('AIN') or exit('NO DICE!');

interface AIN_Mail_Interface
{
	public function send($mTo, $sSubject, $sTextPlain, $sTextHtml, $sFromName = null, $sFromEmail = null);
}

?>