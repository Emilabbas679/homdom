<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_agency_in extends AIN_Component
{

    public function process()
    {
        $slug = $this->request()->get('req2');
        $data = AIN::getService('homdom.core')->homdom_get_agency(['status_id' => 11 , 'slug' => $slug]);
        if (isset($data['status']) and $data['status'] == 'success' and $data['data']['count'] == 1) {
            $agency = $data['data']['rows'][0];
            $this->template()->assign(['agency'=> $agency]);
            $meta['title'] = $agency['title'].' | '. AIN::getPhrase('homdom.agencies')  .' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);

            $meta['description'] = html_entity_decode(substr(strip_tags($agency['description']), 0, 160));
            $this->template()->assign(['meta'=> $meta]);


        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
