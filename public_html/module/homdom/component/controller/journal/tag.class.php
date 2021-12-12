<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_journal_tag extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        $page = 1;
        if (isset($_GET['page']))
            $page = $_GET['page'];
        $slug = $this->request()->get('req3');
        $tag = AIN::getService('homdom.core')->homdom_get_article_tag(['slug' => $slug, 'status_id' => 11]);
        if (isset($tag['status']) and $tag['status'] == 'success' and $tag['data']['count'] == 1){
            $tag = $tag['data']['rows'][0];
            $articles = AIN::getService('homdom.core')->homdom_get_article(['status_id' => 11, 'limit' => 9, 'page'=> $page, 'tag_id' => $tag['id']]);
            $count = (isset($articles['data']) and isset($articles['data']['count'])) ? $articles['data']['count'] : 0;
            $articles = (isset($articles['data']) and isset($articles['data']['rows'])) ? $articles['data']['rows'] : [];
            $this->template()->assign(['articles' => $articles]);
            AIN::getLib('pager')->set(['page' => $page, 'size' => 9, 'count' => $count]);

            $categories = AIN::getService('homdom.core')->homdom_get_article_category(['status_id' => 11, 'limit' => 20]);

            $this->template()->assign(['categories' => $categories['data']['rows']]);

            $meta['title'] = AIN::getPhrase('homdom.'.$tag['phrase']).' | '.AIN::getPhrase('homdom.blog') .' | '.$_SERVER['SERVER_NAME'];
            $this->template()->setTitle($meta['title']);
            $meta['description'] = AIN::getPhrase('homdom.blog_tag_page_meta_description');
            $this->template()->assign(['meta'=> $meta]);
        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
