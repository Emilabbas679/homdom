<?php

defined('AIN') or exit('NO DICE!');

class smart_service_smart extends AIN_Service
{
    private $aMenus = [];

    public function __construct()
    {

	}
	public function recaptcha_verify( $aVals )
	{
		$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
		$recaptcha_response = $aVals['recaptcha_response'];
		$recaptcha_secret = "6LfpZoEaAAAAAKoz0bnOhY4aO3i4DOG24a-HlYvv";
		$recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
		$recaptcha = json_decode($recaptcha);
		
        if ($recaptcha->success==true && isset($recaptcha->score) && $recaptcha->score >= 0.5) 
		{			
			return true;
        }
		
		return false;
	}


}
