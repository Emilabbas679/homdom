<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_journal extends AIN_Component
{
    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        $page = 1;

        if( $this->request()->get('req2') > 0 )
            return AIN::getLib('module')->setController('homdom.journal-in');

        $meta['title'] = AIN::getPhrase('homdom.blog') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.journal_page_meta_description');
        $this->template()->assign(['meta'=> $meta]);


        if (isset($_GET['page']))
            $page = $_GET['page'];
        $articles = AIN::getService('homdom.core')->homdom_get_article(['status_id' => 11, 'limit' => 9, 'page'=> $page]);
        $count = (isset($articles['data']) and isset($articles['data']['count'])) ? $articles['data']['count'] : 0;
        $articles = (isset($articles['data']) and isset($articles['data']['rows'])) ? $articles['data']['rows'] : [];
        $this->template()->assign(['articles' => $articles]);
        AIN::getLib('pager')->set(['page' => $page, 'size' => 9, 'count' => $count]);
        $categories = AIN::getService('homdom.core')->homdom_get_article_category(['status_id' => 11, 'limit' => 20]);
        $this->template()->assign(['categories' => $categories['data']['rows']]);
    }


}

