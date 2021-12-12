<?php

defined('AIN') or exit('NO DICE!');

class Homdom_component_controller_auth_verify extends AIN_Component
{
    public function process()
    {
        if ( auth() ) $this->url()->send('', array(), 'Already login');
        $aVals = [];
        if ($aVals = $this->request()->getArray('val')) {
            if (isset($aVals['hash'])) {
                $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
                $verify = AIN::getService('homdom.core')->user_verify_password(['verify_link' => AIN::getParam('adnetwork.site_url').'/'.$locale.'/auth/verify?val[hash]={hash_code}', 'hash_code' => $aVals['hash']]);
                if (isset($verify['status']) and $verify['status'] == 'success')
                    AIN::addMessage('adnetwork.new_password_sent_to_your_email');
                else{
                    if (isset($user_check['messages'])){
                        foreach ($user_check['messages'] as $v)
                            AIN_ERROR::set($v);
                    }
                    if (isset($user['error']))
                        AIN_ERROR::set($user['error']);
                }
            }
            else
                AIN_ERROR::set(AIN::getPhrase('adnetwork.hash_code_not_found'));
            $this->template()->assign(['aForms' => $aVals]);
        }


        $this->template()->assign(['aForms' => $aVals]);
    }
    public function clean()
    {

    }


}

?>