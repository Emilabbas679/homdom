<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_auth_password extends AIN_Component
{
    public function process()
    {
        if ( auth() ) $this->url()->send('', array(), 'Already login');
        $aVals = [];
        if ($aVals = $this->request()->getArray('val')) {
            $user_check = AIN::getService('homdom.core')->get_user(['email' => $aVals['email']]);
            if (isset($user_check['status']) and $user_check['status'] == 'success') {
                $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
                $mail_send = AIN::getService('homdom.core')->user_new_password(['verify_link' => AIN::getParam('adnetwork.site_url').'/'.$locale.'/auth/verify?val[hash]={hash_code}', 'email' => $aVals['email']]);
                if (isset($mail_send['status']) and $mail_send['status'] == 'success') {
                    AIN::addMessage('adnetwork.new_password_sent_to_your_email');
                }
                else
                    AIN_ERROR::set(AIN::getPhrase('adnetwork.something_went_wrong'));
            }
            else{
                if (isset($user_check['messages'])){
                    foreach ($user_check['messages'] as $v)
                        AIN_ERROR::set($v);
                }
                if (isset($user['error']))
                    AIN_ERROR::set($user['error']);
                AIN_ERROR::set(AIN::getPhrase("adnetwork.error_user"));
            }
            $this->template()->assign(['aForms' => $aVals]);

        }


        $this->template()->assign(['aForms' => $aVals]);
    }

    public function clean()
    {

    }


}

?>