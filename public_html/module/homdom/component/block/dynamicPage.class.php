<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class homdom_component_block_dynamicPage extends AIN_Component
{
    public function process()
    {
        $page = $_GET['page'];
        $opt = ['limit' => 20, 'page' => $page,'status_id' => 11];
        $page = AIN::getService('homdom.core')->get_page(['slug' => $_GET['slug'], ['status_id' => 11]]);
        $page = $page['data']['rows'][0];

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
        if (isset($offerRaws['status']) and $offerRaws['status'] == 'success' and $offerRaws['data']['count'] > 0) {
            $offers = $offerRaws['data']['rows'];
            $o_count = count($offers);
            for ($i=0; $i < $o_count ; $i++)
                $offers[$i] = AIN::getService('homdom.helpers')->offerToArray($offers[$i]);
        }
        else{
            die();
        }
        $this->template()->assign(array('offers' => $offers));
    }
}

?>