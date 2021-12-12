<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_informer extends AIN_Component
{

    public function process()
    {

        $iframe_url = 'https://homdom.az/banner-page';
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $requests = (isset(explode('?', $actual_link)[1])) ? explode('?', $actual_link)[1] : '';

        $iframe_url .= '?'.$requests;
        $aVals = [];
        if (count($_GET) > 0)
            $aVals = $_GET;

        if (!isset($aVals['title_color']))
            $aVals['title_color'] = '#cccccc';
        if (!isset($aVals['offer_count']))
            $aVals['offer_count'] = 5;
        if (!isset($aVals['title_bg_color']))
            $aVals['title_bg_color'] = '#ffffff';
        if (!isset($aVals['offer_title_color']))
            $aVals['offer_title_color'] = '#000000';
        if (!isset($aVals['offer_title_bg_color']))
            $aVals['offer_title_bg_color'] = '#f1e8e8';


        $this->template()->assign(['searchForm' => $aVals]);
        $this->template()->assign(['iframe' => $iframe_url]);


    }


}
