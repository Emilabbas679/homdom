<?php

defined('AIN') or exit('NO DICE!');

class video_Component_Controller_Register extends AIN_Component
{
    public function process()
    {
        if (!auth ()) {
            $meta['title'] = AIN::getPhrase('homdom.register') .' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);
            $meta['description'] = AIN::getPhrase('homdom.register_page_meta_description');
            $this->template()->assign(['meta'=> $meta]);

            if ($aVals = $this->request()->getArray('val')) {
                $regInfo = [];
                $regInfo ["user_name"] = strstr($aVals["email"], '@', true);
                $regInfo ["full_name"] = $aVals["firstname"] . ' ' . $aVals["lastname"];
                $regInfo ["gender"] = $aVals["gender"];
                $regInfo ["birthday"] = $aVals["birthday"];
                $regInfo ["email"] = $aVals["email"];
                $regInfo ["phone"] = '994' . $aVals["phone"];
                $regInfo ["password"] = $aVals["password"];
                $regInfo ["user_group_id"] = 2;
                $regInfo ["status_id"] = 0;
                $regInfo ["language_id"] = "az";
                $regInfo ["currency_id"] = "AZN";
                $result = AIN::getService('video')->create_user($regInfo);
                if ($result["status"] == "success") {
                    AIN::getLib('url')->send('');
                }
            }
        }
        else{
            AIN::getLib('url')->send('settings');
        }
    }
}
