<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_complex_room extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');

        $slug = $this->request()->get('req2');
        $data = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11 , 'slug' => $slug]);
        if (isset($data['status']) and $data['status'] == 'success' and $data['data']['count'] == 1) {
            $complex = $data['data']['rows'][0];
            $this->template()->assign(['complex'=> $complex]);

            $meta['title'] = AIN::getPhrase('homdom.room_designs').' | '.$complex['name'].' | '.AIN::getPhrase('homdom.complex').' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);
            $meta['description'] = html_entity_decode(substr(strip_tags($complex['description']), 0, 160));
            $this->template()->assign(['meta'=> $meta]);


            $rooms = [];
            $data = AIN::getService('homdom.core')->homdom_get_complex_room(['status_id' => 11 ,'limit'=>100, 'complex_id' =>  $data['data']['rows'][0]['id']]);
            if (isset($data['data']) and isset($data['data']['rows']))
                $rooms = $data['data']['rows'];

            $sorted_rooms = [];

            foreach ($rooms as $item)
                $sorted_rooms[$item['room_count']][] = $item;
            ksort($sorted_rooms);
            $this->template()->assign(['rooms'=> $sorted_rooms]);

            $type = 'all';
            if (isset($_GET['type']) and $_GET['type'] != 'all')
                $type = explode('-',$_GET['type'])[0];

            $this->template()->assign(['type' => $type]);


        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
