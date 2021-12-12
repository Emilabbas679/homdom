<?php

defined('AIN') or exit('NO DICE!');

class Homdom_Service_user extends AIN_Service
{
    private $_sNameCookieUserId = 'user_id';
    private $_sNameCookieHash = 'user_hash';
    private $_aUser = [];
    private $_iOverrideUserId = null;
    private $_aParam = [];

    public function __construct()
    {
        $this->_sTable = AIN::getT('user');

        $iUserId = (int) AIN::getCookie($this->_sNameCookieUserId);
        $sPasswordHash = AIN::getCookie($this->_sNameCookieHash);

        if ($iUserId > 0) {
			
            $aRow = AIN::sendApi('user_auth', ['user_id' => $iUserId, 'user_hash' => $sPasswordHash]);

            if (isset($aRow['data'])) {
                $this->_aUser = $aRow['data'];
            } else {
                $this->_setDefault();
                $this->logout();
            }
        } else {
            $this->_setDefault();
        }
    }
    private function _setDefault()
    {
        $this->_aUser = [
            'user_id' => 0,
            'user_group_id' => GUEST_USER_ID,
        ];
    }
    public function handleStatus()
    {		
        return null;
    }
    public function logout()
    {
        AIN::removeCookie($this->_sNameCookieUserId);

        AIN::setCookie($this->_sNameCookieUserId, 0, -1);
        AIN::setCookie($this->_sNameCookieHash, 0, -1);
    }
    public function login($sLogin, $sPassword, $bRemember = false, $sType = 'email', $bNoPasswordCheck = false)
    {
        $aRow = AIN::sendApi('get_user', ['phone'=>$sLogin]);
        if (count($aRow['data'])>0) {
            $aRow = $aRow['data'][0];
            $opt = ['login' => $aRow['email'], 'password' => $sPassword, 'remember' => $bRemember];
            $aRow = AIN::sendApi('user_login', $opt);
            if ('success' == $aRow['status']) {
                $data = $aRow['data'];
                $sPasswordHash = AIN::getLib('hash')->setRandomHash(AIN::getLib('hash')->setHash($data['password'], $data['password_salt']));
                $iTime = ($bRemember ? (AIN_TIME + 3600 * 24 * 365) : 0);

                AIN::setCookie($this->_sNameCookieUserId, $data['user_id'], $iTime, (AIN::getParam('core.force_secure_site') ? true : false));
                AIN::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime, (AIN::getParam('core.force_secure_site') ? true : false));

                return [true, $aRow['data']];
            } else {
                AIN_Error::set(implode(',', $aRow['messages']));

                return [false, $aRow];
            }
        }
        else {
            AIN_Error::set(implode(',', $aRow['messages']));
            return [false, $aRow];
        }
    }
    public function isUser()
    {
        return ($this->_aUser['user_id']) ? true : false;
    }
    public function getUserId()
    {
        if (null !== $this->_iOverrideUserId) {
            return $this->_iOverrideUserId;
        }

        return (int) $this->_aUser['user_id'];
    }
	
	

    public function getUserBy($sVar = null)
    {
        if (null === $sVar && isset($this->_aUser['user_id']) && $this->_aUser['user_id'] > 0) {
            return $this->_aUser;
        }
        if (isset($this->_aUser[$sVar])) 
		{
            return $this->_aUser[$sVar];
        }

        return false;
    }
	
	

    // Group ID of admin related user (in case of editor or some other groups)
    public function getRequesterUserGroup($uID)
    {
        $uSeR = db()
        ->select('user_group_id')
        ->from($this->_sTable)
        ->where('user_id = '.$uID)
        ->execute('getRow');

        return $uSeR;
    }
    // Group ID of admin related user (in case of editor or some other groups)





    public function getGroup($iGroupId)
    {
        if ($aApi = AIN::getService('video')->get_user_group(['user_group_id' => $iGroupId])) {
            if (isset($aApi['data'])) {
                return $aApi['data'];
            }
        }
    }

    public function get_user_group_params($sName)
    {
		$sCacheId = $this->cache()->set(array('adnetwork', "user_group_{$this->_aUser['user_group_id']}"));
		if (!($this->user_group = $this->cache()->get($sCacheId)))
		{
			$aApi = AIN::getService('video')->get_user_group_params(['user_group_id' => $this->_aUser['user_group_id']]);
			if (isset($aApi['data'])) {
                $this->user_group = $aApi['data'];
            }
			$this->cache()->save($sCacheId, $this->user_group);			
		}

		return isset($this->user_group[$sName]) ? $this->user_group[$sName] : AIN_Error::trigger('Invalid user group setting param: '.$sName, E_USER_WARNING);
    }





    public function get($iGroupId, $module_id = null)
    {
        if ($aApi = AIN::getService('video')->get_user_group_setting(['user_group_id' => $iGroupId,  'module_id' => $module_id])) {
            if (isset($aApi['data'])) {
                return $aApi['data'];
            }
        }
    }

    public function groupUpdate($iGroupId, $aVals)
    {
        $aVals['user_group_id'] = $iGroupId;

        if ($aApi = AIN::getService('video')->update_user_group_setting($aVals)) {
            if (isset($aApi['data'])) {
                return $aApi['data'];
            }
        }
    }

    public function loginFacebook($sLogin, $bRemember = false)
    {
        $aRow = AIN::sendApi('get_user', ['login' => $sLogin]);
        if ('success' == $aRow['status']) {
            $data = $aRow['data'][0];
            $sPasswordHash = AIN::getLib('hash')->setRandomHash(AIN::getLib('hash')->setHash($data['password'], $data['password_salt']));
            $iTime = ($bRemember ? (AIN_TIME + 3600 * 24 * 365) : 0);

            AIN::setCookie($this->_sNameCookieUserId, $data['user_id'], $iTime, (AIN::getParam('core.force_secure_site') ? true : false));
            AIN::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime, (AIN::getParam('core.force_secure_site') ? true : false));

            return [true, $aRow['data']];
        } else {
            AIN_Error::set(implode(',', $aRow['messages']));

            return [false, $aRow];
        }
    }


    public function loginAdmin($sLogin, $sPassword, $bRemember = false, $sType = 'email', $bNoPasswordCheck = false)
    {
        $opt = ['login' => $sLogin, 'password' => $sPassword, 'remember' => $bRemember];
        $aRow = AIN::sendApi('user_login', $opt);
        if ('success' == $aRow['status']) {
            $data = $aRow['data'];
            if ($data['user_group_id'] ==1 ){
                $sPasswordHash = AIN::getLib('hash')->setRandomHash(AIN::getLib('hash')->setHash($data['password'], $data['password_salt']));
                $iTime = ($bRemember ? (AIN_TIME + 3600 * 24 * 365) : 0);

                AIN::setCookie($this->_sNameCookieUserId, $data['user_id'], $iTime, (AIN::getParam('core.force_secure_site') ? true : false));
                AIN::setCookie($this->_sNameCookieHash, $sPasswordHash, $iTime, (AIN::getParam('core.force_secure_site') ? true : false));

                return [true, $aRow['data']];
            }
            AIN_Error::set(AIN::getPhrase('homdom.permission_error'));
            return false;

        } else {
            AIN_Error::set(implode(',', $aRow['messages']));

            return [false, $aRow];
        }

    }

}
