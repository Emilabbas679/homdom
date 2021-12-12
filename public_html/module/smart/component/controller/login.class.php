<?php

defined('AIN') or exit('NO DICE!');

class Smart_Component_Controller_Login extends AIN_Component
{
    public function process()
    {
        if ( auth() )
        {
            $this->url()->send('', array(), 'Already login');
        }

        if ($aVals = $this->request()->getArray('val')) {
            if( isset($aVals['recaptcha_response']) ) {
                if( AIN::getService('smart')->recaptcha_verify($aVals) )
                {
                    list($bLogged, $aUser) = (AIN::getService('video.user')->login($aVals['login'], $aVals['password'], (isset($aVals['remember_me']) ? true : false), 'both'));
                    if ($bLogged) {
                        if ('login' == $this->request()->get('req2')) {
                            return $this->url()->send('advertiser.advert.index');
                        }
                        return $this->url()->send('current');
                    }
                }
                else
                {
                    AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
                }
            }
            else{
                AIN_ERROR::set(AIN::getPhrase('adnetwork.error_captcha'));
            }
        }
        $this->template()->setTemplate('blank');
    }
    public function clean()
    {

    }
}

?>
