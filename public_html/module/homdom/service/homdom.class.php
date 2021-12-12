<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_homdom extends AIN_Service
{
    public function __construct()
    {
		
		
    }
    public function send($action = 'get_video', $parameters = [])
    {		
		(AIN_DEBUG ? AIN_Debug::start('CoreApi') : false);
	
		$url = 'https://every.ainsyndication.com/api.php';   		
		$data = [];
        $data['action'] = $action;		
 	    //$data['actionBy'] = AIN::isUser() ? AIN::getUserBy('email') : 'Guest';		
 	    $data['action_user_id'] = AIN::isUser() ? AIN::getUserBy('user_id') : 0;

        $parameters['token'] = $this->tokenGenerate();

        if( AIN::getParam('adnetwork.ssp_id') > 1 )
            $parameters['ssp_id'] = AIN::getParam('adnetwork.ssp_id');

        if( AIN::getParam('adnetwork.channel_id') > 1 )
            $parameters['channel_id'] = AIN::getParam('adnetwork.channel_id');

		$parameters['site_title'] = AIN::getParam('core.site_title');
		$parameters['language_id'] = AIN::getLib('locale')->getLangId();
		
        $data['parameters'] = $parameters;
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
        $data_string = json_encode($data, JSON_NUMERIC_CHECK);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);  // Seems like good practice		
		
		(AIN_DEBUG ? AIN_Debug::end('CoreApi', array('name' => $action, 'params' => json_encode($parameters, JSON_NUMERIC_CHECK) )) : false);		
		
        return json_decode($result, true);
    }

    public function recaptcha_verify( $aVals )
    {
		return true;
		
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = $aVals['recaptcha_response'];
        $recaptcha_secret = "6LfpZoEaAAAAAKoz0bnOhY4aO3i4DOG24a-HlYvv";
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        if ($recaptcha->success==true && isset($recaptcha->score) && $recaptcha->score >= 0.5)
            return true;
        return false;
    }

    public function price($price = 0, $num = 2)
    {
        return number_format($price, $num, ',', '.');
    }
    public function __call($method, $args)
    {
        return $this->send($method, $args[0] ?? []);
    }

    public function tokenGenerate() {
        $length = 16;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $simple_string = $randomString.'smartbee-'.$_SERVER['SERVER_ADDR'].'-'.time().$randomString;
        $ciphering  = "aes128";
        $option = 0;
        $encryption_iv = '1234567890123456';
        $encryiption_key = "Smartbee Azerbaijan";
        $encryption = openssl_encrypt($simple_string, $ciphering,$encryiption_key, $option ,$encryption_iv );
        return $encryption;
    }
	
	
	
	
	
	public function homdom_get_offer( $data = [] )
	{
		$data = $this->send('homdom_get_offer', [ 'limit' => $data['limit'] ])['data']['rows'];
		foreach($data as $key => $row )
		{
			$data[$key]['image'] = json_decode($row['image'], true); 
			$data[$key]['url'] = AIN::getLib('url')->makeUrl('offer', [ $row['id'] ]); 
		}
		return $data;		
	}



}
