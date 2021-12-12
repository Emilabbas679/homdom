<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Journal_Category_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_article_category(['id' => $iEditId])) {
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
                $aVals['slug'] = AIN::getService('homdom.helpers')->slugify($aVals['phrase']);
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_article_category($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('journal.category.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {
                    if (($data = AIN::getService('homdom.core')->homdom_create_article_category($aVals))) {
                        if ('success' == $data['status']) {
                            $this->url()->send('journal.category.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
            'title' => AIN::getPhrase('homdom.phrase'),
            'value' => (isset($aVals['phrase']) ? $aVals['phrase'] : (isset($aForms['phrase']) ? $aForms['phrase'] : '')),
            'type' => 'input:text',
            'id' => 'phrase',
            'class' => 'phrase',
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
