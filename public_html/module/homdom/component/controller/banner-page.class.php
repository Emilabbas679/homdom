<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_banner_page extends AIN_Component
{

    public function process()
    {
        $aVals = $_GET;
        $page = 1;

        if (isset($aVals['page']))
            $page = $aVals['page'];

        $limit = 5;
        if (isset($vals['offer_count']) and $vals['offer_count'] != '')
            $limit = $vals['offer_count'];
        $opt = ['limit' => $limit, 'page' => $page,'status_id' => 11];
        $opt['property_type_id'] = 1;
        if (isset($aVals['offer_type']) and in_array($aVals['offer_type'], ['1', '2']))
            $opt['offer_type'] = $aVals['offer_type'];
        if (isset($aVals['min_price']) and $aVals['min_price'] != '' )
            $opt['min_price'] = (int) $aVals['min_price'];
        if (isset($aVals['max_price']) and $aVals['max_price'] != '' )
            $opt['max_price'] = (int) $aVals['max_price'];
        if (isset($aVals['min_area']) and $aVals['min_area'] != '' )
            $opt['min_area'] = (int) $aVals['min_area'];
        if (isset($aVals['max_area']) and $aVals['max_area'] != '' )
            $opt['max_area'] = (int) $aVals['max_area'];
        if (isset($aVals['building_type']) and in_array($aVals['building_type'], [0, 1]))
            $opt['building_type'] = $aVals['building_type'];
        if (isset($aVals['property_type_id']) and in_array($aVals['property_type_id'], [1, 2, 3, 4, 5, 6]))
            $opt['property_type_id'] = $aVals['property_type_id'];
        if (isset($aVals['targets']))
            $opt['targets'] = $aVals['targets'];
        if (isset($aVals['metros']))
            $opt['metros'] = $aVals['metros'];
        if (isset($aVals['garage_type']))
            $opt['garage_type'] = $aVals['garage_type'];
        if (isset($aVals['material']))
            $opt['material'] = $aVals['material'];
        if (isset($aVals['garage_status']))
            $opt['garage_status'] = $aVals['garage_status'];
        if (isset($aVals['agency_id']))
            $opt['agency_id'] = $aVals['agency_id'];
        if (isset($aVals['building_exit']))
            $opt['building_exit'] = $aVals['building_exit'];
        if (isset($aVals['commercial_type']))
            $opt['commercial_type'] = $aVals['commercial_type'];
        if (isset($aVals['field_type']))
            $opt['field_type'] = $aVals['field_type'];
        if (isset($aVals['localities']))
            $opt['localities'] = $aVals['localities'];
        if (isset($aVals['district_id']))
            $opt['district_id'] = $aVals['district_id'];
        if (isset($aVals['room_count']))
            $opt['room_count'] = $aVals['room_count'];
        if (isset($aVals['building_name']) and $aVals['building_name'] != '')
            $opt['building_name'] = $aVals['building_name'];
        if (isset($aVals['flat_floor']))
            $opt['flat_floor'] = $aVals['flat_floor'];
        if (isset($aVals['quality']))
            $opt['quality'] = $aVals['quality'];
        if (isset($aVals['utilities_include']) and in_array($aVals['utilities_include'], ['1', '0']))
            $opt['utilities_include'] = $aVals['utilities_include'];
        if (isset($aVals['ceiling_height']))
            $opt['ceiling_height'] = $aVals['ceiling_height'];
        if (isset($aVals['window_view']))
            $opt['window_view'] = $aVals['window_view'];
        if (isset($aVals['balcony']))
            $opt['balcony'] = $aVals['balcony'];
        if (isset($aVals['sanitary']))
            $opt['sanitary'] = $aVals['sanitary'];
        if (isset($aVals['mortgage']) and in_array($aVals['mortgage'], ['1', '0']))
            $opt['mortgage'] = $aVals['mortgage'];
        if (isset($aVals['bill_of_sale']) and in_array($aVals['bill_of_sale'], ['1', '0']))
            $opt['bill_of_sale'] = $aVals['bill_of_sale'];
        if (isset($aVals['seller_type']) and in_array($aVals['seller_type'], ['1', '0']))
            $opt['seller_type'] = $aVals['seller_type'];
        if (isset($aVals['lift']) and in_array($aVals['lift'], ['2', '3']))
            $opt['lift'] = $aVals['lift'];
        if (isset($aVals['parking']))
            $opt['parking'] = $aVals['parking'];
        if (isset($aVals['floors_total_max']) and $aVals['floors_total_max'] != '')
            $opt['floors_total_max'] = $aVals['floors_total_max'];
        if (isset($aVals['floors_total_min']) and $aVals['floors_total_min'] != '')
            $opt['floors_total_min'] = $aVals['floors_total_min'];
        if (isset($aVals['built_year_min']) and $aVals['built_year_min'] != '')
            $opt['built_year_min'] = $aVals['built_year_min'];
        if (isset($aVals['built_year_max']) and $aVals['built_year_max'] != '')
            $opt['built_year_max'] = $aVals['built_year_max'];
        if (isset($aVals['built_not_delivery']) and $aVals['built_not_delivery'] == '1')
            $opt['built_not_delivery'] = $aVals['built_not_delivery'];
        if (isset($aVals['imagine']))
            $opt['imagine'] = $aVals['imagine'];
        if (isset($aVals['kitchen_area']) and $aVals['kitchen_area'] != '')
            $opt['kitchen_area'] = $aVals['kitchen_area'];
        if (isset($aVals['building_id']) and $aVals['building_id'] != '')
            $opt['building_id'] = $aVals['building_id'];


        $url_parse_2 = $this->request()->get('req2');
        $url_parse_3 = $this->request()->get('req3');

        if ($url_parse_2 != '' and $url_parse_3 != '') {
            if ($url_parse_2 == 'sell' and $url_parse_3 == '1-otaqli') {
                $opt['offer_type'] = 1;
                $opt['room_count'] = ['1'];
                $aVals['offer_type'] = 1;
                $aVals['room_count'] = ['1'];
            }
            if ($url_parse_2 == 'sell' and $url_parse_3 == 'evler') {
                $opt['offer_type'] = 1;
                $opt['property_type_id'] = 2;
                $aVals['offer_type'] = 1;
                $aVals['property_type_id'] = 2;
            }
            if ($url_parse_2 == 'rent' and $url_parse_3 == '1-otaqli') {
                $opt['offer_type'] = 2;
                $opt['room_count'] = ['1'];
                $aVals['offer_type'] = 2;
                $aVals['room_count'] = ['1'];
            }
        }
        elseif($url_parse_2 != '') {
            if ($url_parse_2 == 'vip')
                $opt['vip_status_id'] = 1;
            elseif($url_parse_2 == 'rent') {
                $opt['offer_type'] = 2;
                $aVals['offer_type'] = 2;
            }
            elseif($url_parse_2 == 'magaza'){
                $aVals['property_type_id'] = 2;
                $opt['property_type_id'] = 6;
            }
            elseif($url_parse_2 == 'obyekt'){
                $aVals['property_type_id'] = 2;
                $opt['property_type_id'] = 6;
            }
        }
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

        $sections = [];

        $sections['title_color'] = '#cccccc';
        $sections['title_bg_color'] = '#ffffff';
        $sections['offer_title_color'] = '#000000';
        $sections['offer_title_bg_color'] = '#f1e8e8';

        if (isset($aVals['block_title']) and $aVals['block_title'] !='')
            $sections['block_title'] = $aVals['block_title'];
        if (isset($aVals['title_color']) and $aVals['title_color'] !='')
            $sections['title_color'] = $aVals['title_color'];
        if (isset($aVals['title_bg_color']) and $aVals['title_bg_color'] !='')
            $sections['title_bg_color'] = $aVals['title_bg_color'];
        if (isset($aVals['offer_title_color']) and $aVals['offer_title_color'] !='')
            $sections['offer_title_color'] = $aVals['offer_title_color'];
        if (isset($aVals['offer_title_bg_color']) and $aVals['offer_title_bg_color'] !='')
            $sections['offer_title_bg_color'] = $aVals['offer_title_bg_color'];

        $this->template()->assign(['offers' => $offers]);
        $this->template()->assign(['sections' => $sections]);
        $this->template()->setTemplate('empty');
    }


}
