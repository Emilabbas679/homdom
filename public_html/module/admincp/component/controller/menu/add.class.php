<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Menu_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->get_menu(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $bIsEdit = true;
                }
            }
        }
        if ($aVals = $this->request()->getArray('val')) {
            AIN::getLib('redis')->del('menus:header');
            AIN::getLib('redis')->del('menus:footer');

            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'title', 'required' => true, 'type' => 'array'],
                    ['field' => 'link', 'required' => true, 'type' => 'string'],
                    ['field' => 'ordering', 'required' => true, 'type' => 'string'],
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
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->update_menu($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('menu.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->create_menu($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('menu.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.link'),
            'value' => (isset($aVals['link']) ? $aVals['link'] : (isset($aForms['link']) ? $aForms['link'] : '')),
            'type' => 'input:text',
            'id' => 'link',
            'class' => 'link',
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.ordering'),
            'value' => (isset($aVals['ordering']) ? $aVals['ordering'] : (isset($aForms['ordering']) ? $aForms['ordering'] : '')),
            'type' => 'input:number',
            'id' => 'ordering',
            'class' => 'ordering',
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


        $menuRows = AIN::getService('homdom.core')->get_menu(['menu_id' => 0,'type' => 1]);
        $mOptions = [0=>AIN::getPhrase('homdom.main_menu')];
        $locale = AIN::getLib('locale')->getLang()[0]['language_id'];

        if (isset($menuRows['data']) and isset($menuRows['data']['count']) and $menuRows['data']['count'] > 0) {
            foreach ($menuRows['data']['rows'] as $row){
                $t = (array) json_decode($row['title']);
                $mOptions[$row['id']] = (isset($t[$locale])) ? $t[$locale] : "";
            }
        }

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.menu_id'),
            'value' => (isset($aVals['menu_id']) ? $aVals['menu_id'] : (isset($aForms['menu_id']) ? $aForms['menu_id'] : '0')),
            'type' => 'select',
            'id' => 'menu_id',
            'class' => 'menu_id',
            'id_css' => 'menu_id',
            'options' => $mOptions,
            'required' => true,
        ];


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.type'),
            'value' => (isset($aVals['type']) ? $aVals['type'] : (isset($aForms['type']) ? $aForms['type'] : '0')),
            'type' => 'select',
            'id' => 'type',
            'class' => 'type',
            'id_css' => 'type',
            'options' => ['0'=> AIN::getPhrase('homdom.header'), '1' => AIN::getPhrase('homdom.footer')],
            'required' => true,
        ];


        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
