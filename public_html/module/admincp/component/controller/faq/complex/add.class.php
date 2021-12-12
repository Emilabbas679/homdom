<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Faq_Complex_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->get_complex_faq(['id' => $iEditId])) {
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
                    ['field' => 'complex_id', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                $aVals['title'] = json_encode($aVals['title']);
                $aVals['content'] = json_encode($aVals['content']);
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->update_complex_faq($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('faq.complex.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->create_complex_faq($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('faq.complex.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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


        $languages = ['az', 'en', 'ru'];

        $vals = ['az' => '', 'en'=> '', 'ru'=>''];
        if (isset($aForms['title'])){
            $title_vals = (array) json_decode($aForms['title']);
            $vals['az'] = (isset($title_vals['az'])) ? $title_vals['az'] : "";
            $vals['en'] = (isset($title_vals['en'])) ? $title_vals['en'] : "";
            $vals['ru'] = (isset($title_vals['ru'])) ? $title_vals['ru'] : "";
        }
        if (isset($aVals['title'])) $vals = $aVals['title'];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.title'),
            'languages' => $languages,
            'value' => $vals,
            'type' => 'translatable',
            'id' => 'title',
            'class' => 'title',
            'required' => true,
        ];


        $vals = ['az' => '', 'en'=> '', 'ru'=>''];
        if (isset($aForms['content'])){
            $c_vals = (array) json_decode($aForms['title']);
            $vals['az'] = (isset($c_vals['az'])) ? $c_vals['az'] : "";
            $vals['en'] = (isset($c_vals['en'])) ? $c_vals['en'] : "";
            $vals['ru'] = (isset($c_vals['ru'])) ? $c_vals['ru'] : "";
        }
        if (isset($aVals['content'])) $vals = $aVals['content'];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.content'),
            'languages' => $languages,
            'value' => $vals,
            'type' => 'translatable',
            'id' => 'content',
            'class' => 'content',
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


        $complexRows = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11, 'limit'=>100]);
        $cOptions = [0=>AIN::getPhrase('homdom.select_complex')];
        $locale = AIN::getLib('locale')->getLang()[0]['language_id'];

        if (isset($complexRows['data']) and isset($complexRows['data']['count']) and $complexRows['data']['count'] > 0) {
            foreach ($complexRows['data']['rows'] as $row){
                $cOptions[$row['id']] = $row['name'];
            }
        }

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.complex'),
            'value' => (isset($aVals['complex_id']) ? $aVals['complex_id'] : (isset($aForms['complex_id']) ? $aForms['complex_id'] : '0')),
            'type' => 'select',
            'id' => 'complex_id',
            'class' => 'complex_id',
            'id_css' => 'complex_id',
            'options' => $cOptions,
            'required' => true,
        ];


        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
