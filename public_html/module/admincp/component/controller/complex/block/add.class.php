<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Complex_Block_Add extends AIN_Component
{
    public function process()
    {

        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->get_complex_block(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $bIsEdit = true;
                }
            }
        }
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'complex_id', 'required' => true, 'type' => 'string'],
                    ['field' => 'title', 'required' => true, 'type' => 'array'],
                    ['field' => 'content', 'required' => true, 'type' => 'array'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {


                if (isset($_FILES['image']) and $_FILES['image']['size'] !=0)
                    $aVals['image'] = AIN::getService('homdom.helpers')->imageUploadS3("image");
                else
                    $aVals['image'] = $aVals['old_image'];
                unset($aVals['old_image']);

                $aVals['title'] = json_encode($aVals['title']);
                $aVals['content'] = json_encode($aVals['content']);
                $aVals['contact'] = json_encode($aVals['contact']);
                
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->update_complex_block($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('complex.block.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {
                    if ($data = AIN::getService('homdom.core')->create_complex_block($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('complex.block.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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

        $aRows = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11, 'limit' => 100]);
        $options = [];
        if(isset($aRows['status']) and $aRows['status'] == 'success'){
            $options = $aRows['data']['rows'];
        }
        $aOptions = [];
        foreach($options as $k=>$v){
            $aOptions[$v['id']] = $v['name'];
        }

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.complex'),
            'value' => (isset($aVals['complex_id']) ? $aVals['complex_id'] : (isset($aForms['complex_id']) ? $aForms['complex_id'] : '11')),
            'type' => 'select',
            'id' => 'complex_id',
            'class' => 'complex_id',
            'id_css' => 'complex_id',
            'options' => $aOptions,
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
            $value = (array) json_decode($aForms['content']);
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.content'),
            'value' => $value,
            'type' => 'translatable',
            'id' => 'content',
            'class' => 'ckeditor',
            'id_css' => 'content',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];




        $value = ['az'=> '', 'en' => '', 'ru'=> ''];
        if($aForms['contact'] != null)
            $value = (array) json_decode($aForms['contact']);
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.button_text'),
            'value' => $value,
            'type' => 'translatable',
            'id' => 'contact',
            'class' => 'ckeditor',
            'id_css' => 'contact',
            'options' => [],
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
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
