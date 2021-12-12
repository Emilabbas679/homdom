<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_offers_mass extends AIN_Component
{
    public function process()
    {
        if ($aVals = $this->request()->getArray('val')) {
            if (!isset($aVals['offer_ids']))
                return AIN_Module::instance()->setController('admincp.offers.index');

            $offer_ids = [];
            foreach ($aVals['offer_ids'] as $id) {
                $offer_ids[(string) $id] = $id;
            }
            $options['offer_ids'] = json_encode($offer_ids);
            $options['targets'] = (isset($aVals['targets'])) ? $aVals['targets'] : [];

            $tgets = [];
            foreach ($options['targets'] as $v)
                $tgets[(string) $v] = $v;
            if (count($tgets) > 0)
                $options['targets'] = json_encode($tgets);

            $options['utilities'] = (isset($aVals['utilities'])) ? $aVals['utilities'] : [];
            $o_utilities = [];
            foreach ($options['utilities'] as $v)
                $o_utilities[(string) $v] = $v;
            if (count($o_utilities) > 0)
                $options['utilities'] = json_encode($o_utilities);

            $options['offer_type'] = (isset($aVals['offer_type'])) ? $aVals['offer_type'] : 0;
            if (isset($aVals['building_type']))
                $options['building_type'] = $aVals['building_type'];
            if (isset($aVals['built_year']) and $aVals['built_year'] != '')
                $options['built_year'] = $aVals['built_year'];
            if (isset($aVals['ceiling_height']) and $aVals['ceiling_height'] != '')
                $options['ceiling_height'] = $aVals['ceiling_height'];

            if (isset($aVals['building_id']) and $aVals['building_id'] != '')
                $options['building_id'] = $aVals['building_id'];
            if (isset($aVals['built_year']) and $aVals['built_year'] != '')
                $options['built_year'] = $aVals['built_year'];
            if (isset($aVals['ceiling_height']) and $aVals['ceiling_height'] != '')
                $options['ceiling_height'] = $aVals['ceiling_height'];
            if (isset($aVals['parking']) and $aVals['parking'] != '')
                $options['parking'] = $aVals['parking'];
            if (isset($aVals['sanitary']) and $aVals['sanitary'] != '')
                $options['sanitary'] = $aVals['sanitary'];
            if (isset($aVals['balcony']) and $aVals['balcony'] != '')
                $options['balcony'] = $aVals['balcony'];
            if (isset($aVals['bill_of_sale']) and $aVals['bill_of_sale'] != '')
                $options['bill_of_sale'] = $aVals['bill_of_sale'];
            if (isset($aVals['price']) and $aVals['price'] != '')
                $options['price'] = $aVals['price'];
            if (isset($aVals['haggle']) and $aVals['haggle'] != '')
                $options['haggle'] = $aVals['haggle'];
            if (isset($aVals['mortgage']) and $aVals['mortgage'] != '')
                $options['mortgage'] = $aVals['mortgage'];


            if (isset($aVals['lift'])) {
                $lift = [];
                foreach ($aVals['lift'] as $val) {
                    $lift[$val] = $val;
                }
                $options['lift'] = json_encode($lift);
            }
            if (isset($aVals['window_view'])) {
                $lift = [];
                foreach ($aVals['window_view'] as $val) {
                    $lift[$val] = $val;
                }
                $options['window_view'] = json_encode($lift);
            }

            $data = AIN::getService('homdom.core')->homdom_mass_offer($options);
            if ('success' == $data['status'])
                $this->url()->send('offers.index', [], AIN::getPhrase('homdom.successfully_updated'));
            else
                AIN_ERROR::set(implode('<br/>', $data['messages']));


        }
        else{
            $offer_ids = [];
            if(isset($_GET['offer_ids']))
                $offer_ids = $_GET['offer_ids'];
            if (count($offer_ids) == 0)
                return AIN_Module::instance()->setController('admincp.offers.index');
            $aForms = [];
            $aForms['offer_ids'] = $offer_ids;
            $this->template()->assign(['aForms' => $aForms]);
            $utilityRows = AIN::getService('homdom.core')->homdom_get_offer_utility(['status_id' => 11, 'limit'=>500 ]);
            if (isset($utilityRows['status']) and $utilityRows['status'] == 'success' and $utilityRows['data']['count'] > 0){
                $this->template()->assign(['utilityRows' => $utilityRows['data']['rows']]);
            }
            else
                $this->template()->assign(['utilityRows' => []]);


        }



    }
}
