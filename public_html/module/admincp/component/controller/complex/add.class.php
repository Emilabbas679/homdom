<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Complex_Add extends AIN_Component
{
    public function process()
    {

        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_complex(['id' => $iEditId])) {
                if (isset($aApi['data']['rows'][0])) {
                    $aForms = $aApi['data']['rows'][0];
                    $aForms['lift'] = (array) json_decode($aForms['lift']);
                    $aForms['image'] = (array) json_decode($aForms['image']);
                    $bIsEdit = true;
                }
            }
        }
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'name', 'required' => true, 'type' => 'string'],
//                    ['field' => 'description', 'required' => true, 'type' => 'string'],
                    ['field' => 'email', 'required' => true, 'type' => 'string'],
                    ['field' => 'logo', 'required' => true, 'type' => 'string'],
                    ['field' => 'cover_photo', 'required' => true, 'type' => 'string'],
                    ['field' => 'phone', 'required' => true, 'type' => 'string'],
//                    ['field' => 'address', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {

                $option = $aVals;
                if(isset($option['image'])) {
                    $images = []; $i=1;
                    foreach ($aVals['image'] as $image) {
                        $images[(string) $i] = $image;
                        $i++;
                    }
                    $option['image'] = json_encode($images);
                }

                if (isset($option['lift'])) {
                    $lift = [];
                    foreach ($option['lift'] as $val) {
                        $lift[$val] = $val;
                    }
                    $option['lift'] = json_encode($lift);
                }

                $option['slug'] = AIN::getService('homdom.helpers')->slugify($option['name']);


                $option['phone'] = str_replace('+','', str_replace(' ', '',str_replace('(','',str_replace(')','',$option['phone']))));

                $option['phone'] = (int) $option['phone'];

                $option['ceiling_height'] = ($option['ceiling_height'] == '') ? 0 : $option['ceiling_height'];
                $option['latitude'] = ($option['latitude'] == '') ? 0 : $option['latitude'];
                $option['price'] = ($option['price'] == '') ? 0 : $option['price'];
                $option['floors_total'] = ($option['floors_total'] == '') ? 0 : $option['floors_total'];
                $option['longitude'] = ($option['longitude'] == '') ? 0 : $option['longitude'];
                $option['built_year'] = ($option['built_year'] == '') ? 0 : $option['built_year'];

                if ($bIsEdit) {
                    $option['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_complex($option))) {
                        if ('success' == $data['status'])
                            $this->url()->send('complex.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->homdom_create_complex($option)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('complex.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
