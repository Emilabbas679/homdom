<?php

defined('AIN') or exit('NO DICE!');

class Video_Component_Controller_Logout extends AIN_Component
{
    private $_sNameCookieUserId = 'user_id';
    private $_sNameCookieHash = 'user_hash';

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');

        AIN::setCookie($this->_sNameCookieUserId, 0, -1, false);
        AIN::setCookie($this->_sNameCookieHash, 0, -1, false);
        AIN::getLib('url')->send('');
    }
}
