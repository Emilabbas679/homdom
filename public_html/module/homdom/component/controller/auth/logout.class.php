<?php

defined('AIN') or exit('NO DICE!');

class Homdom_Component_Controller_Auth_Logout extends AIN_Component
{
    private $_sNameCookieUserId = 'user_id';
    private $_sNameCookieHash = 'user_hash';

    public function process()
    {
        AIN::setCookie($this->_sNameCookieUserId, 0, -1, false);
        AIN::setCookie($this->_sNameCookieHash, 0, -1, false);
        AIN::getLib('url')->send('');
    }
}
