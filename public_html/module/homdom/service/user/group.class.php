<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_user_group extends AIN_Service
{
    public function __construct()
    {

		
    }

    public function getGroup($iGroupId)
    {
        if ($aApi = AIN::getService('video')->get_user_group(['user_group_id' => $iGroupId])) {
            if (isset($aApi['data'])) {
                return $aApi['data'];
            }
        }
    }
}
