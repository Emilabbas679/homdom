<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_faq extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        $categories = [];
        $cats = AIN::getService('homdom.core')->homdom_get_faq_category(['status_id'=>11, 'limit'=>100]);
        if (isset($cats['data']) and isset($cats['data']['count']) and $cats['data']['count'] > 0) {
            $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
            foreach ($cats['data']['rows'] as $row){
                $row['faqs'] = [];
                $row['title'] = (array) json_decode($row['title']);
                $row['title'] = (isset($row['title'][$locale])) ? $row['title'][$locale] : "";
                $categories[$row['id']] = $row;
            }
            $faqRows = AIN::getService('homdom.core')->homdom_get_faq_faq(['status_id'=>11, 'limit' => 100]);
            if (isset($faqRows['data']) and isset($faqRows['data']['count']) and $faqRows['data']['count'] > 0) {
                foreach ($faqRows['data']['rows'] as $row){
                    $row['title'] = (array) json_decode($row['title']);
                    $row['title'] = (isset($row['title'][$locale])) ? $row['title'][$locale] : "";
                    $row['content'] = (array) json_decode($row['content']);
                    $row['content'] = (isset($row['content'][$locale])) ? $row['content'][$locale] : "";

                    $categories[$row['category_id']]['faqs'][] = $row;
                }
            }
        }

        $localityRows = AIN::getService('homdom.core')->homdom_get_district(['region_id' => 10,'status_id'=>11, 'limit' => 100]);
        $localities = [];
        if (isset($localityRows['data']) and isset($localityRows['data']['count']) and $localityRows['data']['count'] > 0) {
            $localities = $localityRows['data']['rows'];
        }
        $districtsRows= AIN::getService('homdom.core')->homdom_get_district(['limit' => 100,'status_id'=>11]);
        $districts = [];
        if (isset($districtsRows['data']) and isset($districtsRows['data']['count']) and $districtsRows['data']['count'] > 0) {
            $districts = $districtsRows['data']['rows'];
        }
        sort($localities);
        sort($districts);
        $this->template()->assign(['categories' => $categories]);
        $this->template()->assign(['districts' => $districts]);
        $this->template()->assign(['localities' => $localities]);
        $this->template()->setTitle(AIN::getPhrase('homdom.faq'));
        
    }


}
