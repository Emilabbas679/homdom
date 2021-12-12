<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_offer extends AIN_Component
{

    public function process()
    {
        $id = $this->request()->get('req2');
        $offer = AIN::getService('homdom.core')->homdom_get_offer(['id' => $id]);
        if (isset($offer['status']) and $offer['status'] == 'success' and count($offer['data']['rows']) == 1){
            $offer = $offer['data']['rows'][0];
            $offer = AIN::getService('homdom.helpers')->offerToArray($offer);
            AIN::getService('homdom.core')->homdom_update_hits_offer(['id' => $id, 'hits' => $offer['hits']+1]);
            $utilities = [];
            if (count($offer['utilities']) > 0){
                $utilities = AIN::getService('homdom.core')->homdom_get_offer_utility(['ids' => $offer['utilities'], 'status_id' => 11]);
                if (isset($utilities['status']) and $utilities['status'] == 'success' and $utilities['data']['count'] > 0)
                    $utilities = $utilities['data']['rows'];
            }
            $targets = [];
            if (count($offer['targets']) > 0){
                $targets = AIN::getService('homdom.core')->homdom_get_target(['ids' => $offer['targets'], 'status_id' => 11]);
                if (isset($targets['status']) and $targets['status'] == 'success' and $targets['data']['count'] > 0)
                    $targets = $targets['data']['rows'];
            }
            $offer['targets'] = $targets;

            $options = ['offer_type' => $offer['offer_type'], 'property_type_id' => $offer['property_type_id'], 'status_id' => 11, 'orderby' => 'rand()', 'limit' => 4];
            if ($offer['room_count'] != 0)
                $options['room_count'] = [$offer['room_count']];
            if ($offer['district_id'] != 0)
                $options['district_id'] = $offer['district_id'];
            if ($offer['locality_id'] != 0)
                $options['locality_id'] = $offer['locality_id'];
            if ($offer['metro_id'] != 0)
                $options['metro_id'] = $offer['metro_id'];

            $similar_offer_rows = AIN::getService('homdom.core')->homdom_get_offer($options);
            $similar_offers = [];
            if (isset($similar_offer_rows['status']) and $similar_offer_rows['status'] == 'success' and isset($similar_offer_rows['data']['rows']))
                $similar_offers = $similar_offer_rows['data']['rows'];
            for ($i=0; $i < count($similar_offers); $i++)
                $similar_offers[$i] = AIN::getService('homdom.helpers')->offerToArray($similar_offers[$i]);

            $this->template()->assign(['offer'=> $offer, 'similar_offers' => $similar_offers]);
            $this->template()->assign(['utilities'=> $utilities]);
            $title = AIN::getService('homdom.helpers')->getOfferTitle($offer);

            $meta['title'] = $title.' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);

            $meta['description'] = html_entity_decode(substr(strip_tags($offer['description']), 0, 160));
            $this->template()->assign(['meta'=> $meta]);
            $this->template()->assign(['title'=> $title]);

        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
