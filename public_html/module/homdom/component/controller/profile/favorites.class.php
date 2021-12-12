<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_profile_favorites extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');

        $meta['title'] = AIN::getPhrase('homdom.favorites').' | '.AIN::getPhrase('homdom.profile') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.favorites_meta_description');
        $this->template()->assign(['meta'=> $meta]);


        $page = 1;
        if (isset($_GET['page']))
            $page = $_GET['page'];
        $aRows = AIN::getService('homdom.core')->homdom_get_favority(['user_id' => getUserBy('user_id'), 'limit' => 10,'page' => $page]);

        $count = 0;
        $items = [];
        if (isset($aRows['status']) and $aRows['status'] == 'success' and isset($aRows['data']['count'])) {
            $count = $aRows['data']['count'];
            $items = $aRows['data']['rows'];
        }

        AIN::getLib('pager')->set(['page' => $page, 'size' => 10, 'count' => $count]);
        $this->template()->assign(['items' => $items]);

        $this->template()->setTitle(AIN::getPhrase('homdom.my_favorites'));
    }


}
