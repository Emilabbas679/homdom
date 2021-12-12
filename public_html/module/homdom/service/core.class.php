<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_core extends AIN_Service
{
    public function __construct()
    {


    }

    public function send($action = 'get_advert', $parameters = [])
    {
        (AIN_DEBUG ? AIN_Debug::start('CoreApi') : false);

//        $url = 'http://49.12.92.130/api.php';
//        $url = 'https://every.smartbee.az/api.php';
        $url = 'https://every.ainsyndication.com/api.php';
        $data = [];
        $data['action'] = $action;
        //$data['actionBy'] = AIN::isUser() ? AIN::getUserBy('email') : 'Guest';
        $data['action_user_id'] = AIN::isUser() ? AIN::getUserBy('user_id') : 0;

        if( AIN::getParam('adnetwork.ssp_id') > 1 and $action != 'get_slot' ) {
            $parameters['ssp_id'] = AIN::getParam('adnetwork.ssp_id');
        }

        $parameters['site_title'] = AIN::getParam('core.site_title');

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
    public function price($price = 0, $num = 2)
    {
        return number_format($price, $num, ',', '.');
    }
    public function __call($method, $args)
    {
        return $this->send($method, $args[0] ?? []);
    }
}
