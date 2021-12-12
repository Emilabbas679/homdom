<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Location_Target_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_target(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $bIsEdit = true;
                }
            }
        }


        if ($aVals = $this->request()->getArray('val')) {

            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'phrase', 'required' => true, 'type' => 'string'],
                ]
            );
            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if (isset($aVals['translation'])) {
                    foreach ($aVals['translation'] as $k=>$updateVal) {
                        if ($updateVal != '' and $updateVal != null) {
                            $opt = [
                                'module_id' => 'homdom',
                                'var_name' =>  $aVals['phrase'],
                                'text' => $updateVal,
                                'language_id' => $k
                            ];
                            AIN::getService('homdom.core')->update_one_phrase($opt);
                        }
                    }
                    unset($aVals['translation']);
                }

                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_target($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('location.target.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {
                    if (($data = AIN::getService('homdom.core')->homdom_create_target($aVals))) {
                        if ('success' == $data['status']) {
                            $this->url()->send('location.target.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
        $aTableForm[$table]['title'] = AIN::getPhrase('homdom.target_add');
        $aTableForm[$table]['data'] = [];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.phrase'),
            'value' => (isset($aVals['phrase']) ? $aVals['phrase'] : (isset($aForms['phrase']) ? $aForms['phrase'] : '')),
            'type' => 'input:text',
            'id' => 'phrase',
            'class' => 'phrase',
            'required' => true,
        ];


        $aOptions = ['11' => AIN::getPhrase('homdom.ad_static_status_11'), '12' =>AIN::getPhrase('homdom.ad_static_status_12')];


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

        if ($aForms['id'] == 0)
            $get_phrase = null;
        else
            $get_phrase = (isset($aForms['phrase'])) ? $aForms['phrase'] : null;
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.translation'),
            'value' => AIN::getService('homdom.helpers')->getPhraseTranslation($get_phrase),
            'type' => 'translatable',
            'id' => 'translation',
            'class' => 'translation',
            'id_css' => 'translation',
            'options' => $aOptions,
            'required' => true,
            'languages' => AIN::getService('homdom.helpers')->siteLanguages()
        ];

        

        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
