<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Translation_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($aVals = $this->request()->getArray('val')) {

            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'var_name', 'required' => true, 'type' => 'string'],
                    ['field' => 'en', 'required' => true, 'type' => 'string'],
                    ['field' => 'az', 'required' => true, 'type' => 'string'],
                    ['field' => 'ru', 'required' => true, 'type' => 'string'],
                ]
            );
            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                $text = ['az' => $aVals['az'], 'en' => $aVals['en'], 'ru'=>$aVals['ru'], 'tr' => $aVals['az']];
                unset($aVals['az']);
                unset($aVals['en']);
                unset($aVals['ru']);
//                unset($aVals['tr']);
                $aVals['text'] = $text;
                $aVals['module_id'] = 'homdom';
                $data = AIN::getService('homdom.core')->create_phrase($aVals);
                $this->url()->send('translation.index');

            }
        }

        //Form Tablo
        $aTableForm = [];
        $table = 0;
        $aTableForm[$table]['title'] = AIN::getPhrase('homdom.campaign_add');
        $aTableForm[$table]['data'] = [];


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.var_name'),
            'value' => (isset($aVals['var_name']) ? $aVals['var_name'] : ""),
            'type' => 'input:text',
            'id' => 'var_name',
            'class' => 'var_name',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.en'),
            'value' => (isset($aVals['en']) ? $aVals['en'] : ""),
            'type' => 'input:text',
            'id' => 'en',
            'class' => 'en',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.az'),
            'value' => (isset($aVals['az']) ? $aVals['az'] : ""),
            'type' => 'input:text',
            'id' => 'az',
            'class' => 'az',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.ru'),
            'value' => (isset($aVals['ru']) ? $aVals['ru'] : ""),
            'type' => 'input:text',
            'id' => 'ru',
            'class' => 'ru',
            'required' => true,
        ];







        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
