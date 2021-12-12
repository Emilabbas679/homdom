<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_journal_in extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        $slug = $this->request()->get('req2');
        $article = AIN::getService('homdom.core')->homdom_get_article(['slug' => $slug, ['status_id' => 11]]);
        if (isset($article['status']) and $article['status'] == 'success' and $article['data']['count'] == 1){
            $categories = AIN::getService('homdom.core')->homdom_get_article_category(['status_id' => 11, 'limit' => 20]);
            $article = $article['data']['rows'][0];
            $this->template()->assign(['article'=> $article]);
            $this->template()->assign(['categories'=> $categories['data']['rows']]);
            $tags = [];
            $tag_ids = [];
            if ($article['tags'] != null) {
                $tag_ids = (array) json_decode($article['tags']);
                $tags = AIN::getService('homdom.core')->homdom_get_article_tag(['ids' => $tag_ids]);
                if (isset($tags['status']) and $tags['status'] == 'success')
                    $tags = $tags['data']['rows'];
                else
                    $tags = [];
            }
            $this->template()->assign(['tags'=> $tags]);

            $related_articles = AIN::getService('homdom.core')->homdom_get_related_article(['category_id' => $article['category_id'], 'tag_ids' => $tag_ids, 'limit' => 9, 'not_id' => $article['id']]);
            $this->template()->setTitle($article['title'] .' | '.$_SERVER['SERVER_NAME'] );
            $meta['title'] = $article['title'] .' | '.$_SERVER['SERVER_NAME'];
            $meta['description'] = html_entity_decode(substr(strip_tags($article['text']), 0, 160));
            $this->template()->assign(['meta'=> $meta]);

            if (isset($related_articles['status']) and $related_articles['status'] == 'success' and $related_articles['data']['count'] > 0)
                $this->template()->assign(['related_articles' => $related_articles['data']['rows']]);
            else
                $this->template()->assign(['related_articles' => []]);
            
        }
        else{
            return AIN_Module::instance()->setController('homdom.index');
        }
    }


}
