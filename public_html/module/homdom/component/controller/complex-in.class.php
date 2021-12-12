<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_complex_in extends AIN_Component
{

    public function process()
    {
        $slug = $this->request()->get('req2');
        $data = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11 , 'slug' => $slug]);
        if (isset($data['status']) and $data['status'] == 'success' and $data['data']['count'] == 1) {
            $complex = $data['data']['rows'][0];
            $this->template()->assign(['complex'=> $complex]);

            $meta['title'] = $complex['name'].' | '.AIN::getPhrase('homdom.complex').' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);

            $meta['description'] = html_entity_decode(substr(strip_tags($complex['description']), 0, 160));
            $this->template()->assign(['meta'=> $meta]);


            $rooms = [];
            $data = AIN::getService('homdom.core')->homdom_get_complex_room(['status_id' => 11,'limit'=>100, 'complex_id' =>  $data['data']['rows'][0]['id']]);
            if (isset($data['data']) and isset($data['data']['rows']))
                $rooms = $data['data']['rows'];

            $sorted_rooms = [];

            foreach ($rooms as $item)
                $sorted_rooms[$item['room_count']][] = $item;
            ksort($sorted_rooms);
            $this->template()->assign(['rooms'=> $sorted_rooms]);


            $faqs = [];
            $faqRows = AIN::getService('homdom.core')->get_complex_faq(['status_id' => 11,'complex_id'=>$complex['id'], 'limit' => 100, 'orderBy' => 'rand()' ]);
            $locale = AIN::getLib('locale')->getLang()[0]['language_id'];

            if (isset($faqRows['data']) and isset($faqRows['data']['rows'])) {
                foreach ($faqRows['data']['rows'] as $row){
                    $row['title'] = (array) json_decode($row['title']);
                    $row['title'] = (isset($row['title'][$locale])) ? $row['title'][$locale] : "";
                    $row['content'] = (array) json_decode($row['content']);
                    $row['content'] = (isset($row['content'][$locale])) ? $row['content'][$locale] : "";

                    $faqs[] = $row;
                }
            }
            $this->template()->assign(['faqs'=> $faqs]);

            $other_complexes = [];

            $complexesRow = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11 , 'limit'=> 10, 'orderBy' => 'rand()']);
            if (isset($complexesRow['data']) and isset($complexesRow['data']['rows']))
                $other_complexes = $complexesRow['data']['rows'];
            $this->template()->assign(['other_complexes'=> $other_complexes]);


            $blockRows = AIN::sendApi('get_complex_block', ['status_id' => 11, 'limit' => 10, 'complex_id' => $complex['id']]);
            $blocks = [];
            if (isset($blockRows['data']) and isset($blockRows['data']['rows'])) {
                foreach ($blockRows['data']['rows'] as $row) {
                    $title = (array) json_decode($row['title']);
                    $row['title'] = (isset($title[$locale])) ? $title[$locale] : "";
                    $content = (array) json_decode($row['content']);
                    $row['content'] = (isset($content[$locale])) ? $content[$locale] : "";
                    $contact = (array) json_decode($row['contact']);
                    $row['contact'] = (isset($contact[$locale])) ? $contact[$locale] : "";
                    $blocks[] = $row;
                }
            }


            $this->template()->assign(['blocks'=> $blocks]);

        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
