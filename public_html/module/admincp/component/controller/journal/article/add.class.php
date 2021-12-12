<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Journal_Article_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_article(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $bIsEdit = true;
                }
            }
        }
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'title', 'required' => true, 'type' => 'string'],
                    ['field' => 'text', 'required' => true, 'type' => 'string'],
                    ['field' => 'category_id', 'required' => true, 'type' => 'string', 'not_equal' => 0],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                $tags = [];
                if (isset($aVals['tags'])) {
                    foreach ($aVals['tags'] as $tag) {
                        $tag_int = (int) $tag;
                        if ($tag_int > 0)
                            $tags[$tag_int] = $tag_int;
                        else{
                            $opt = [
                                'phrase' => $tag,
                                'slug' =>   AIN::getService('homdom.helpers')->slugify($tag),
                                'status_id' => 11
                            ];
                            $t_create = AIN::getService('homdom.core')->homdom_create_article_tag($opt);
                            if (isset($t_create['status']) and $t_create['status'] == 'success'){
                                $tags[$t_create['data']['id']] = $t_create['data']['id'];
                            }
                        }
                    }
                }

                if ($aVals['old_image'] == '') {
                    if (isset($_FILES['image']) and $_FILES['image']['size'] !=0) {
                        $aVals['image'] = AIN::getService('homdom.helpers')->imageUploadS3("image");
                    }
                    else
                        $aVals['image'] = null;
                }
                else{
                    $aVals['image'] = $aVals['old_image'];
                }
                unset($aVals['old_image']);
                $aVals['language_id'] = 'az';
                $aVals['tags'] = json_encode($tags);
                $aVals['user_id'] = getUserBy('user_id');
                $aVals['slug'] = AIN::getService('homdom.helpers')->slugify($aVals['title']);
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_article($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('journal.article.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->homdom_create_article($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('journal.article.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
                        } else {
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                        }
                    }
                }
            }
        }

        //Form Tablo
        $aTableForm = [];
        $table = 0;
        $aTableForm[$table]['title'] = AIN::getPhrase('homdom.campaign_add');
        $aTableForm[$table]['data'] = [];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.title'),
            'value' => (isset($aVals['title']) ? $aVals['title'] : (isset($aForms['title']) ? $aForms['title'] : '')),
            'type' => 'input:text',
            'id' => 'title',
            'class' => 'title',
            'required' => true,
        ];


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.text'),
            'value' => (isset($aVals['text']) ? htmlentities($aVals['text']) : (isset($aForms['text']) ? htmlentities($aForms['text']) : '')),
            'type' => 'input:textarea',
            'id' => 'text',
            'class' => 'ckeditor',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.image'),
            'value' => (isset($aVals['image']) ? $aVals['image'] : (isset($aForms['image']) ? $aForms['image'] : '')),
            'type' => 'input:dropify',
            'id' => 'image',
            'class' => 'dropify',
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.old_image'),
            'value' => (isset($aVals['image']) ? $aVals['image'] : (isset($aForms['image']) ? $aForms['image'] : '')),
            'type' => 'input:hidden',
            'id' => 'old_image',
            'class' => 'old_image',
            'required' => true,
        ];


        $aOptions = ['11' => AIN::getPhrase('homdom.status_id_11'), '12' =>AIN::getPhrase('homdom.status_id_12')];


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.status'),
            'value' => (isset($aVals['status_id']) ? $aVals['status_id'] : (isset($aForms['status_id']) ? $aForms['status_id'] : '11')),
            'type' => 'select',
            'id' => 'status_id',
            'class' => 'status_id',
            'id_css' => 'status_id',
            'options' => $aOptions,
            'required' => true,
        ];

        $aCatRows = AIN::getService('homdom.core')->homdom_get_article_category(['status_id' => 11]);
        $catOptions = [];
        $catOptions[0] = AIN::getPhrase('homdom.select_category');
        if (isset($aCatRows['status']) and $aCatRows['status'] == 'success') {
            foreach ($aCatRows['data']['rows'] as $item) {
                $catOptions[$item['id']] = AIN::getPhrase('homdom.'.$item['phrase']);
            }
        }

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.category_id'),
            'value' => (isset($aVals['category_id']) ? $aVals['category_id'] : (isset($aForms['category_id']) ? $aForms['category_id'] : 0)),
            'type' => 'select',
            'id' => 'category_id',
            'class' => 'category_id',
            'id_css' => 'category_id',
            'options' => $catOptions,
            'required' => true,
        ];


        $a_tags = [];
        if (isset($aForms['tags']) and $aForms['tags'] != null) {
            $tag_ids = (array) json_decode($aForms['tags']);
            $tags = AIN::getService('homdom.core')->homdom_get_article_tag(['ids' => $tag_ids]);
            if (isset($tags['status']) and $tags['status'] == 'success') {
                foreach ($tags['data']['rows'] as $t) {
                    $a_tags[$t['id']] = $t['phrase'];
                }
            }
        }

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.tags'),
            'value' => (isset($aVals['tags']) ? $aVals['tags'] : (isset($aForms['tags']) ? $aForms['tags'] : 0)),
            'type' => 'select2:multiple',
            'id' => 'tags',
            'class' => 'tags',
            'id_css' => 'tags',
            'options' => $a_tags,
            'required' => true,
        ];

        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
