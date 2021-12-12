<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Offers_Add extends AIN_Component
{
    public function process()
    {
        $aForms = [];
        $aForms['offer_type'] = 'sell';
        $aForms['property_type_id'] = 1;
        $aForms['id'] = 0;
        $aForms['type_1'] = [];
        $aForms['type_1']['area'] = [];
        $aForms['type_2'] = [];
        $aForms['type_2']['area'] = [];
        $aForms['type_3'] = [];
        $aForms['type_3']['area'] = [];
        $aForms['type_4'] = [];
        $aForms['type_5'] = [];
        $aForms['type_6'] = [];
        $aForms['image'] = [];
        $aForms['video'] = [];

        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');

        $iEditId = 0;
        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            $offer = AIN::getService('homdom.core')->homdom_get_offer(['id' => $iEditId]);
            if (isset($offer['status']) and $offer['status'] == 'success' and  count($offer['data']['rows'])  == 1) {
                $offer = $offer['data']['rows'][0];
                $offer = AIN::getService('homdom.helpers')->offerToArray($offer);

                $offer['type_1'] = [
                    'building_type' => $offer['building_type'],
                    'building_id' => $offer['building_id'],
                    'built_year' => $offer['built_year'],
                    'delivery_type' => ($offer['delivery_date'] == null or $offer['delivery_date'] == 0) ? 0 : 1 ,
                    'ceiling_height' => $offer['ceiling_height'],
                    'parking' => $offer['parking'],
                    'lift' => $offer['lift'],
                    'room_count' => $offer['room_count'],
                    'area' => $offer['room_space'],
                    'sanitary' => $offer['sanitary'],
                    'quality' => $offer['quality'],
                    'window_view' => $offer['window_view'],
                    'bill_of_sale' => $offer['bill_of_sale'],
                    'utilities' => $offer['utilities'],
                ];

                $offer['type_2'] = [
                    'built_year' => $offer['built_year'],
                    'ceiling_height' => $offer['ceiling_height'],
                    'material' => $offer['material'],
                    'parking' => $offer['parking'],
                    'room_count' => $offer['room_count'],
                    'area' => $offer['room_space'],
                    'sanitary' => $offer['sanitary'],
                    'quality' => $offer['quality'],
                    'window_view' => $offer['window_view'],
                    'bill_of_sale' => $offer['bill_of_sale'],
                    'utilities' => $offer['utilities'],
                ];

                $offer['type_3'] = [
                    'field_type' => $offer['field_type'],
                    'area' => ['all' => $offer['area']],
                ];
                $offer['type_4'] = [
                    'garage_type' => $offer['garage_type'],
                    'material' => $offer['material'],
                    'garage_status' => $offer['garage_status'],
                    'building_name' => $offer['building_name'],
                    'area' => $offer['area'],
                    'utilities' => $offer['utilities'],
                ];
                $offer['type_5'] = [
                    'building_exit' => $offer['building_exit'],
                    'room_count' => $offer['room_count'],
                    'quality' => $offer['quality'],
                    'area' => $offer['area'],
                    'utilities' => $offer['utilities'],
                ];
                $offer['type_6'] = [
                    'commercial_type_id' => $offer['commercial_type_id'],
                    'building_entrance' => $offer['building_entrance'],
                    'area' => $offer['area'],
                    'utilities' => $offer['utilities'],
                ];
                $aForms = $offer;
            }
            else
                AIN::getLib('url')->send('');
        }

        if($aVals = $this->request()->getArray('val')) {
            $option = [];
            if(isset($aVals['images'])) {
                $images = []; $i=1;
                foreach ($aVals['images'] as $image) {
                    $images[(string) $i] = $image;
                    $i++;
                }
                $option['image'] = json_encode($images);
            }
            if(isset($aVals['videos'])) {
                $videos = []; $i=1;
                foreach ($aVals['videos'] as $video) {
                    $videos[(string) $i] = $video;
                    $i++;
                }
                $option['video'] = json_encode($videos);
            }

            $option['offer_type'] = (isset($aVals['offer_type'])) ? $aVals['offer_type'] : 1;
            $option['property_type_id'] = (isset($aVals['property_type_id'])) ? $aVals['property_type_id'] : 1;
            $option['address'] = (isset($aVals['address'])) ? $aVals['address'] : "";
            $option['address_detail'] = (isset($aVals['address_detail'])) ? $aVals['address_detail'] : "";
            $option['status_id'] = (isset($aVals['status_id'])) ? (int) $aVals['status_id'] : 12;

//            var_dump($option); die();

            if (isset($aVals['validity_date'])) {
                $v_date = explode('.', $aVals['validity_date']);
                $aVals['validity_date'] = $v_date[2].'-'.$v_date[1].'-'.$v_date[0];
            }
            else $option['validity_date'] = null;
            $option['validity_date'] = (isset($aVals['validity_date'])) ? $aVals['validity_date'] : null;

            $option['latitude'] = (isset($aVals['latitude']) and $aVals['latitude'] != null ) ? $aVals['latitude'] : "0";
            $option['longitude'] = (isset($aVals['longitude']) and $aVals['longitude'] != null) ? $aVals['longitude'] : "0";
            $option['property_type'] = 1;
            $option['property_category_id'] = 0;

            $option['region_id'] = (isset($aVals['region_id'])) ? $aVals['region_id'] : 0;
            $option['district_id'] = (isset($aVals['district_id'])) ? $aVals['district_id'] : 0;
            $option['locality_id'] = (isset($aVals['locality_id'])) ? $aVals['locality_id'] : 0;
            $option['metro_id'] = (isset($aVals['metro_id'])) ? $aVals['metro_id'] : 0;
            $option['floors_total'] = (isset($aVals['floors_total']) and $aVals['floors_total'] != null) ? $aVals['floors_total'] : 0;
            $option['flat_floor'] = (isset($aVals['flat_floor']) and $aVals['flat_floor'] != null) ? $aVals['flat_floor'] : 0;
            $option['balcony'] = (isset($aVals['balcony'])) ? $aVals['balcony'] : 0;
            $option['mortgage'] = (isset($aVals['mortgage'])) ? $aVals['mortgage'] : 0;
            $option['haggle'] = (isset($aVals['haggle'])) ? $aVals['haggle'] : 0;
            $option['quality'] = (isset($aVals['quality'])) ? $aVals['quality'] : 0;
            $option['description'] = (isset($aVals['description'])) ? $aVals['description'] : "";
            $option['price'] = (isset($aVals['price']) and $aVals['price'] != null) ? (string) $aVals['price'] : 0;
            $option['delivery_date'] = 0;
            if ($option['property_type_id'] == 1) {
                $type_vals = $aVals['type_1'];
                $option['bill_of_sale'] = (isset($type_vals['bill_of_sale'])) ? $type_vals['bill_of_sale'] : 0;
                if (isset($type_vals['window_view'])) {
                    $w_view = [];
                    foreach ($type_vals['window_view'] as $val) {
                        $w_view[$val] = $val;
                    }
                    $option['window_view'] = json_encode($w_view);
                }
                $option['quality'] = (isset($type_vals['quality'])) ? $type_vals['quality'] : 0;
                $option['building_type'] = (isset($type_vals['building_type'])) ? $type_vals['building_type'] : 0;
                $option['building_id'] = (isset($type_vals['building_id'])) ? $type_vals['building_id'] : 0;
                if ((int) $option['building_id'] == 0) {
                    $option['building_name'] = $option['building_id'];
                    $option['building_id'] = 0;
                    $option['delivery_date'] = 0;
                }
                else{
                    $building = AIN::getService('homdom.core')->homdom_get_building(['id' => (int) $option['building_id']]);
                    if (isset($building['status']) and $building['status'] == 'success' and $building['data']['count'] == 1) {
                        $option['building_name'] = $building['data']['rows'][0]['building_name'];
                        $option['delivery_date'] = ($building['data']['rows'][0]['delivery_year'] != null) ? $building['data']['rows'][0]['delivery_year'] : 0;
                    }
                    else{
                        $option['delivery_date'] = 0;
                    }
                }
                $option['built_year'] = (isset($type_vals['built_year']) and $type_vals['built_year'] != null) ? $type_vals['built_year']: 0;
                $option['ceiling_height'] = (isset($type_vals['ceiling_height']) and $type_vals['ceiling_height'] != null) ? $type_vals['ceiling_height']: 0;
                $option['delivery_type'] = (isset($type_vals['delivery_type'])) ? $type_vals['delivery_type'] : 0;
                $option['parking'] = (isset($type_vals['parking'])) ? $type_vals['parking'] : 0;
                $option['delivery_type'] = (isset($type_vals['delivery_type'])) ? $type_vals['delivery_type'] : 0;
                $option['sanitary'] = (isset($type_vals['sanitary'])) ? $type_vals['sanitary'] : 0;
                if (isset($type_vals['lift'])) {
                    $lift = [];
                    foreach ($type_vals['lift'] as $val) {
                        $lift[$val] = $val;
                    }
                    $option['lift'] = json_encode($lift);
                }
                $option['room_count'] = (isset($type_vals['room_count'])) ? $type_vals['room_count'] : 0;
                if (isset($type_vals['area'])) {
                    $option['area'] = (isset($type_vals['area']['all']) and $type_vals['area']['all'] !=null) ? $type_vals['area']['all'] : 0;
                    $area = [];
                    foreach ($type_vals['area'] as $key => $val) {
                        $area[$key] = $val;
                    }
                    $option['room_space'] = json_encode($area);
                }
                if (isset($type_vals['utilities'])) {
                    $utilities = [];
                    foreach ($type_vals['utilities'] as $key => $val) {
                        $utilities[$val] = $val;
                    }
                    $option['utilities'] = json_encode($utilities);
                }
            }
            elseif($option['property_type_id'] == 2) {
                $type_vals = $aVals['type_2'];
                $option['bill_of_sale'] = (isset($type_vals['bill_of_sale'])) ? $type_vals['bill_of_sale'] : 0;
                if (isset($type_vals['window_view'])) {
                    $w_view = [];
                    foreach ($type_vals['window_view'] as $val) {
                        $w_view[$val] = $val;
                    }
                    $option['window_view'] = json_encode($w_view);
                }
                $option['quality'] = (isset($type_vals['quality'])) ? $type_vals['quality'] : 0;
                $option['built_year'] = (isset($type_vals['built_year'])) ? $type_vals['built_year'] : 0;
                $option['ceiling_height'] = (isset($type_vals['ceiling_height']) and $type_vals['ceiling_height'] != null) ? $type_vals['ceiling_height']: 0;
                $option['material'] = (isset($type_vals['material']) and $type_vals['material'] != null) ? $type_vals['material']: 0;
                $option['parking'] = (isset($type_vals['parking'])) ? $type_vals['parking'] : 0;
                $option['sanitary'] = (isset($type_vals['sanitary'])) ? $type_vals['sanitary'] : 0;
                $option['room_count'] = (isset($type_vals['room_count'])) ? $type_vals['room_count'] : 0;

                if (isset($type_vals['area'])) {
                    $option['area'] = (isset($type_vals['area']['all']) and $type_vals['area']['all'] !=null) ? $type_vals['area']['all'] : 0;
                    $area = [];
                    foreach ($type_vals['area'] as $key => $val) {
                        $area[$key] = $val;
                    }
                    $option['room_space'] = json_encode($area);
                }
                if (isset($type_vals['utilities'])) {
                    $utilities = [];
                    foreach ($type_vals['utilities'] as $key => $val) {
                        $utilities[$val] = $val;
                    }
                    $option['utilities'] = json_encode($utilities);
                }
            }
            elseif($option['property_type_id'] == 3) {
                $type_vals = $aVals['type_3'];

                if (isset($type_vals['area'])) {
                    $option['area'] = (isset($type_vals['area']['all']) and $type_vals['area']['all'] !=null) ? $type_vals['area']['all'] : 0;
                }
                $option['field_type'] = (isset($type_vals['field_type'])) ? $type_vals['field_type'] : 0;
            }
            elseif($option['property_type_id'] == 4) {
                $type_vals = $aVals['type_4'];
                $option['garage_type'] = (isset($type_vals['garage_type'])) ? $type_vals['garage_type'] : 0;
                $option['material'] = (isset($type_vals['material']) and $type_vals['material'] != null) ? $type_vals['material']: 0;
                $option['garage_status'] = (isset($type_vals['garage_status']) and $type_vals['garage_status'] != null) ? $type_vals['garage_status']: 0;
                $option['building_name'] = (isset($type_vals['building_name']) and $type_vals['building_name'] != null) ? $type_vals['building_name']: 0;
                $option['area'] = (isset($type_vals['area']) and $type_vals['area'] != null) ? $type_vals['area']: 0;
                if (isset($type_vals['utilities'])) {
                    $utilities = [];
                    foreach ($type_vals['utilities'] as $key => $val) {
                        $utilities[$val] = $val;
                    }
                    $option['utilities'] = json_encode($utilities);
                }
            }
            elseif($option['property_type_id'] == 5) {
                $type_vals = $aVals['type_5'];
                $option['building_exit'] = (isset($type_vals['building_exit'])) ? $type_vals['building_exit'] : 0;
                $option['area'] = (isset($type_vals['area']) and $type_vals['area'] != null) ? $type_vals['area']: 0;
                $option['room_count'] = (isset($type_vals['room_count']) and $type_vals['room_count'] != null) ? $type_vals['room_count']: 0;
                $option['quality'] = (isset($type_vals['quality']) and $type_vals['quality'] != null) ? $type_vals['quality']: 0;
                if (isset($type_vals['utilities'])) {
                    $utilities = [];
                    foreach ($type_vals['utilities'] as $key => $val) {
                        $utilities[$val] = $val;
                    }
                    $option['utilities'] = json_encode($utilities);
                }
            }
            elseif($option['property_type_id'] == 6) {
                $type_vals = $aVals['type_6'];
                $option['building_entrance'] = (isset($type_vals['building_entrance'])) ? $type_vals['building_entrance'] : 0;
                $option['area'] = (isset($type_vals['area']) and $type_vals['area'] != null) ? $type_vals['area']: 0;
                $option['commercial_type_id'] = (isset($type_vals['commercial_type_id']) and $type_vals['commercial_type_id'] != null) ? $type_vals['commercial_type_id']: 0;
                if (isset($type_vals['utilities'])) {
                    $utilities = [];
                    foreach ($type_vals['utilities'] as $key => $val) {
                        $utilities[$val] = $val;
                    }
                    $option['utilities'] = json_encode($utilities);
                }
            }
            
            $option['user_id'] = ($iEditId > 0) ? $offer['user_id'] : getUserBy('user_id');
            if ($option['offer_type'] == 'sale')
                $option['offer_type'] = 1;
            else
                $option['offer_type'] = 2;

            if ($iEditId > 0) {
                $option['id'] = $iEditId;
                $sendApi = AIN::getService('homdom.core')->homdom_update_offer($option);
            }
            else{
                $sendApi = AIN::getService('homdom.core')->homdom_create_offer($option);
            }
            if (isset($sendApi['status']) and $sendApi['status'] == 'success') {
                AIN::getLib('url')->send('offers');
            }
            else{
                AIN_ERROR::set(implode('<br/>', $sendApi['messages']));
            }
        }
        


        $utilityRows = AIN::getService('homdom.core')->homdom_get_offer_utility(['status_id' => 11, 'limit'=>500 ]);
        $rows = [1=>[], 2=>[], 3=>[],4=>[], 5=>[], 6=>[] ];

        if (isset($utilityRows['status']) and $utilityRows['status'] == 'success' and $utilityRows['data']['count'] > 0){
            foreach ($utilityRows['data']['rows'] as $row) {
                $rows[$row['property_type_id']][] = $row;
            }
            $this->template()->assign(['utilityRows' => $rows]);
        }
        else
            $this->template()->assign(['utilityRows' => $rows]);

        $commercialTypes = AIN::getService('homdom.core')->homdom_get_offer_type(['status_id' => 11, 'limit'=>500 ]);
        if (isset($commercialTypes['status']) and $commercialTypes['status'] == 'success' and $commercialTypes['data']['count'] > 0){
            $this->template()->assign(['commercialTypes' => $commercialTypes['data']['rows']]);
        }
        else
            $this->template()->assign(['commercialTypes' => []]);

        if (isset($aVals) and count($aVals) > 0) {
            $this->template()->assign(['aForms' => $aVals]);
        }
        else{
            $this->template()->assign(['aForms' => $aForms]);
        }

    }
}
