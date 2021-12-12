<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Complex_Room_Add extends AIN_Component
{
    public function process()
    {

        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_complex_room(['id' => $iEditId])) {
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
                    ['field' => 'room_count', 'required' => true, 'type' => 'string'],
                    ['field' => 'area', 'required' => true, 'type' => 'string'],
                    ['field' => 'price', 'required' => true, 'type' => 'string'],
//                    ['field' => 'max_price', 'required' => true, 'type' => 'string'],
                    ['field' => 'image', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_complex_room($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('complex-room.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {
                    if ($data = AIN::getService('homdom.core')->homdom_create_complex_room($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('complex-room.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
                        } else {
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                        }
                    }
                }
            }
        }


        if (isset($aVals) and count($aVals) > 0) {
            $this->template()->assign(['aForms' => $aVals]);
        }
        else{
            $this->template()->assign(['aForms' => $aForms]);
        }

    }
}
