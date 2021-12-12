<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_static extends AIN_Component
{

    public function process()
    {
        $slug = $this->request()->get('req2');
        $page = AIN::getService('homdom.core')->get_static_page(['slug' => $slug, ['status_id' => 11]]);

        if (isset($page['status']) and $page['status'] == 'success' and $page['data']['count'] == 1){
            $page = $page['data']['rows'][0];
            $lang = AIN::getLib('locale')->getLang()[0]['language_id'];

            $meta_title = (array) json_decode($page['meta_title']);
            if (isset($meta_title[$lang]))
                $meta_title = $meta_title[$lang];
            else
                $meta_title = '';

            $meta_description = (array) json_decode( $page['meta_description']);
            if (isset($meta_description[$lang]))
                $meta_description = $meta_description[$lang];
            else
                $meta_description = '';

            $title = (array) json_decode($page['title']);
            if (isset($title[$lang]))
                $title = $title[$lang];
            else
                $title = '';

            $page['content'] = (array) json_decode($page['content']);
            if (isset($page['content'][$lang]))
                $page['content'] = $page['content'][$lang];
            else
                $page['content'] = '';

            $this->template()->assign(['page'=> $page]);
            $meta['description'] = $meta_description;
            $meta['title'] = $meta_title.' | '.$_SERVER['SERVER_NAME'];
            $meta['og:image'] = $page['og_image'];
            $this->template()->assign(['meta'=> $meta]);
            $this->template()->setTitle($title .' | '.$_SERVER['SERVER_NAME'] );
        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
