<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_adnetwork extends AIN_Service
{
    public function __construct()
    {
		
		
		
    }
	public function send($action = 'get_advert', $parameters = [])
    {
		
		
        $url = 'http://37.61.223.106:6001/rest/run/api';
        $data = [];
        $data['action'] = $action;
        $data['actionBy'] = AIN::isUser() ? AIN::getUserBy('email') : 'Guest';

        foreach ($parameters as $key => $value) {
            if ('integer' == gettype($value)) {
                $parameters[$key] = (string) $value;
            } elseif ('array' == gettype($value)) {
                foreach ($value as $key2 => $value2) {
                    if ('integer' == gettype($value2)) {
                        $parameters[$key][$key2] = (string) $value2;
                    }
                }
            }
        }

        $parameters['page'] = isset($parameters['page']) ? $parameters['page'] : '1';
        $parameters['size'] = isset($parameters['size']) ? $parameters['size'] : '100';

        $data['parameters'] = $parameters;
        $headers = ['Accept: application/json', 'Content-Type: application/json'];
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);  // Seems like good practice

        return json_decode($result, true);
    }

    public function __call($method, $args)
    {
        return $this->send($method, $args[0]);
    }
}
