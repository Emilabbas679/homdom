<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_auth_login extends AIN_Component
{
    public function process()
    {
        if (auth ())
            AIN::getLib('url')->send('');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aVals = $this->request()->getArray('val');
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'phone', 'required' => true, 'type'=>'string'],
                    ['field' => 'password', 'required' => true, 'type'=>'string']
                ]
            );
            if (count($validation) > 0) {
                foreach ($validation as $items){
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            }
            else{
                if (isset($aVals['recaptcha_response'])) {
                    if (AIN::getService('homdom')->recaptcha_verify($aVals)) {
                        $phone = $aVals['phone'];
                        $phone = str_replace('+', '', str_replace('(', '', str_replace(')', '', str_replace(' ','', str_replace('+', '',$phone)))));
                        $data = AIN::getService('homdom.user')->login($phone, $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both');
                        list($bLogged, $aUser) = (AIN::getService('homdom.user')->login($phone, $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both'));
                        if ($bLogged) {
                            if ('login' == $this->request()->get('req2')) {
                                return $this->url()->send('index');
                            }
                            return $this->url()->send('current');
                        }
                    }
                    else
                        AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
                }
                else
                    AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
            }

        }


    }

    public function clean()
    {

    }


}

?>