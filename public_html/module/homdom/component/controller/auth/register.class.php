<?php

defined('AIN') or exit('NO DICE!');

class Homdom_Component_Controller_auth_register extends AIN_Component
{
    public function process()
    {
        if (auth ())
            AIN::getLib('url')->send('');

        $aVals = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aVals = $this->request()->getArray('val');
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'full_name', 'required' => true, 'type' => 'string'],
                    ['field' => 'email', 'required' => true, 'type' => 'string'],
                    ['field' => 'phone', 'required' => true, 'type' => 'string'],
                    ['field' => 'password','min' =>5, 'required' => true, 'type' => 'string']
                ]
            );
            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if (isset($aVals['recaptcha_response'])) {
                    $phone = $aVals['phone'];
                    $phone = str_replace('+', '', str_replace('(', '', str_replace(')', '', str_replace(' ','', str_replace('+', '',$phone)))));
                    $regInfo = [];
                    $regInfo ["user_name"] = strstr($aVals["email"], '@', true);
                    $regInfo ["full_name"] = $aVals["full_name"];
                    $regInfo ["gender"] = 0;
                    $regInfo ["email"] = $aVals["email"];
                    $regInfo ["phone"] = $phone;
                    $regInfo ["password"] = $aVals["password"];
                    $regInfo ["user_group_id"] = 2;
                    $regInfo ["status_id"] = 0;
                    $regInfo ["language_id"] = "az";
                    $regInfo ["currency_id"] = "AZN";
                    $result = AIN::getService('homdom.core')->create_user($regInfo);
                    if (isset($result['status']) and $result["status"] == "success") {
                        list($bLogged, $aUser) = (AIN::getService('homdom.user')->login($phone, $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both'));
                        if ($bLogged) {
                            if ('login' == $this->request()->get('req2')) {
                                return $this->url()->send('index');
                            }
                            return $this->url()->send('current');
                        }
                    }
                    else{
                        if (isset($result['messages'])){
                            foreach ($result['messages'] as $msg)
                                AIN_ERROR::set($msg);
                        }
                        if (isset($result['error']))
                            AIN_Error::set($result['error']);
                    }
                }
                else{
                    AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
                }
            }
        }
        $this->template()->assign('aForms', $aVals);
    }
}
