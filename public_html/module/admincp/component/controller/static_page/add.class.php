<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Static_Page_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->get_static_page(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $bIsEdit = true;
                }
            }
        }
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'title', 'required' => true, 'type' => 'array'],
                    ['field' => 'slug', 'required' => true, 'type' => 'string'],
                    ['field' => 'meta_title', 'required' => true, 'type' => 'array'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                
                if (isset($aVals['image']) and $aVals['image'] == '') {
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

                $aVals['og_image'] = $aVals['image'];
                unset($aVals['image']);


                $aVals['title'] = json_encode($aVals['title']);
                $aVals['meta_description'] = json_encode($aVals['meta_description']);
                $aVals['meta_title'] = json_encode($aVals['meta_title']);
                $aVals['content'] = json_encode($aVals['content']);


                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->update_static_page($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('static_page.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->create_static_page($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('static_page.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
        $aTableForm[$table]['title'] = AIN::getPhrase('homdom.add');
        $aTableForm[$table]['data'] = [];



        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.slug'),
            'value' => (isset($aVals['slug']) ? $aVals['slug'] : (isset($aForms['slug']) ? $aForms['slug'] : '')),
            'type' => 'input:text',
            'id' => 'slug',
            'class' => 'slug',
            'required' => true,
        ];



        if ($aForms['id'] == 0)
            $value = ['az'=> '', 'en' => '', 'ru'=> ''];
        else
            $value = (array) json_decode($aForms['title']);
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.title'),
            'value' => $value,
            'type' => 'translatable',
            'id' => 'title',
            'class' => 'title',
            'id_css' => 'title',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];


        if ($aForms['id'] == 0)
            $value = ['az'=> '', 'en' => '', 'ru'=> ''];
        else
            $value = (array) json_decode($aForms['meta_title']);
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.meta_title'),
            'value' => $value,
            'type' => 'translatable',
            'id' => 'meta_title',
            'class' => 'meta_title',
            'id_css' => 'meta_title',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];



        if ($aForms['id'] == 0)
            $value = ['az'=> '', 'en' => '', 'ru'=> ''];
        else
            $value = (array) json_decode($aForms['meta_description']);
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.meta_description'),
            'value' => $value,
            'type' => 'translatable',
            'id' => 'meta_description',
            'class' => 'meta_description',
            'id_css' => 'meta_description',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];



        if ($aForms['id'] == 0)
            $value = ['az'=> '', 'en' => '', 'ru'=> ''];
        else
            $value = (array) json_decode($aForms['content']);

        $values = [];
        foreach ($value as $k=>$v)
            $values[$k] = htmlentities($v);

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.content'),
            'value' => $values,
            'type' => 'translatable',
            'id' => 'content',
            'class' => 'content',
            'id_css' => 'content',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];



        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.custom_js'),
            'value' => (isset($aVals['custom_js']) ? $aVals['custom_js'] : (isset($aForms['custom_js']) ? $aForms['custom_js'] : '')),
            'type' => 'input:textarea',
            'id' => 'custom_js',
            'class' => 'custom_js',
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.custom_css'),
            'value' => (isset($aVals['custom_css']) ? $aVals['custom_css'] : (isset($aForms['custom_css']) ? $aForms['custom_css'] : '')),
            'type' => 'input:textarea',
            'id' => 'custom_css',
            'class' => 'custom_css',
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.og_image'),
            'value' => (isset($aVals['image']) ? $aVals['image'] : (isset($aForms['og_image']) ? $aForms['og_image'] : '')),
            'type' => 'input:dropify',
            'id' => 'image',
            'class' => 'dropify',
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.old_image'),
            'value' => (isset($aVals['og_image']) ? $aVals['og_image'] : (isset($aForms['og_image']) ? $aForms['og_image'] : '')),
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
        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
