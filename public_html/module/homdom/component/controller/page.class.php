<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_page extends AIN_Component
{

    public function process()
    {
        $slug = $this->request()->get('req2');
        $page = AIN::getService('homdom.core')->get_page(['slug' => $slug, ['status_id' => 11]]);

        if (isset($page['status']) and $page['status'] == 'success' and $page['data']['count'] == 1){
            $page = $page['data']['rows'][0];
            $this->template()->assign(['page'=> $page]);
            $meta['title'] = $page['meta_title'] .' | '.$_SERVER['SERVER_NAME'];
            $meta['description'] = $page['meta_description'];
            $meta['og:image'] = $page['og_image'];
            $this->template()->assign(['meta'=> $meta]);

            $opt = ['limit' => 20, 'page' => 1,'status_id' => 11];
//            $opt['property_type_id'] = 1;
            if ($page['district_id'] != 0)
                $opt['district_id'] = $page['district_id'];
            if ($page['offer_type'] != 0)
                $opt['offer_type'] = $page['offer_type'];
            if ($page['building_type'] != 2)
                $opt['building_type'] = $page['building_type'];
            if ($page['room_count'] != null)
                $opt['room_count'] = (array) json_decode($page['room_count']);


            $offerRaws = AIN::getService('homdom.core')->homdom_get_offer($opt);
            $offers = [];
            $count = 0;
            if (isset($offerRaws['status']) and $offerRaws['status'] == 'success' and $offerRaws['data']['count'] > 0) {
                $offers = $offerRaws['data']['rows'];
                $count = $offerRaws['data']['count'];
                $o_count = count($offers);
                for ($i=0; $i < $o_count ; $i++)
                    $offers[$i] = AIN::getService('homdom.helpers')->offerToArray($offers[$i]);
            }
            $this->template()->assign(['offers' => $offers]);




            $this->template()->assign(['searchForm'=> $opt]);
            $this->template()->assign(['offers'=> $offers]);

            $this->template()->setTitle($page['title'] .' | '.$_SERVER['SERVER_NAME'] );



        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
