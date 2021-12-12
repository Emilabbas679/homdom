<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Page_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->get_page(['id' => $iEditId])) {
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
                    ['field' => 'meta_title', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if ($aVals['image'] == '') {
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

                $aVals['slug'] = AIN::getService('homdom.helpers')->slugify($aVals['title']);
                $rooms = null;
                if (isset($aVals['room_count']) and is_array($aVals['room_count'])) {
                    $rooms = [];
                    foreach ($aVals['room_count'] as $r) {
                        $rooms[(string) $r] = $r;
                    }
                    $aVals['room_count'] = json_encode($rooms);
                }
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->update_page($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('page.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->create_page($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('page.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
            'title' => AIN::getPhrase('homdom.title'),
            'value' => (isset($aVals['title']) ? $aVals['title'] : (isset($aForms['title']) ? $aForms['title'] : '')),
            'type' => 'input:text',
            'id' => 'title',
            'class' => 'title',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.meta_title'),
            'value' => (isset($aVals['meta_title']) ? $aVals['meta_title'] : (isset($aForms['meta_title']) ? $aForms['meta_title'] : '')),
            'type' => 'input:text',
            'id' => 'meta_title',
            'class' => 'meta_title',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.meta_description'),
            'value' => (isset($aVals['meta_description']) ? $aVals['meta_description'] : (isset($aForms['meta_description']) ? $aForms['meta_description'] : '')),
            'type' => 'input:textarea',
            'id' => 'meta_description',
            'class' => 'meta_description',
            'required' => true,
        ];



        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.text'),
            'value' => (isset($aVals['text']) ? $aVals['text'] : (isset($aForms['text']) ? $aForms['text'] : '')),
            'type' => 'input:textarea',
            'id' => 'text',
            'class' => 'ckeditor',
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





        $aOptions = ['0' =>AIN::getPhrase('homdom.all'),'1' => AIN::getPhrase('homdom.offer_type_sell'), '2'=> AIN::getPhrase('homdom.offer_type_rent') ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.offer_type'),
            'value' => (isset($aVals['offer_type']) ? $aVals['offer_type'] : (isset($aForms['offer_type']) ? $aForms['offer_type'] : '1')),
            'type' => 'select',
            'id' => 'offer_type',
            'class' => 'offer_type',
            'id_css' => 'offer_type',
            'options' => $aOptions,
            'required' => true,
        ];


        $aOptions = ['0' =>AIN::getPhrase('homdom.building_type_0'),'1' => AIN::getPhrase('homdom.building_type_1'), '2'=> AIN::getPhrase('homdom.all') ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.building_type'),
            'value' => (isset($aVals['building_type']) ? $aVals['building_type'] : (isset($aForms['building_type']) ? $aForms['building_type'] : '1')),
            'type' => 'select',
            'id' => 'building_type',
            'class' => 'building_type',
            'id_css' => 'building_type',
            'options' => $aOptions,
            'required' => true,
        ];


        $aOptions = [];
        for ($i=1; $i<=5; $i++) {
            $aOptions[(string) $i] = $i;
        }
        $aOptions['6'] = '6+';


        $rooms = [];
        if (isset($aForms['room_count']))
            $rooms = (array) json_decode($aForms['room_count']);

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.room_count'),
            'value' => (isset($aVals['room_count']) ? $aVals['room_count'] : $rooms),
            'type' => 'select2:multiple',
            'id' => 'room_count',
            'class' => 'room_count',
            'id_css' => 'room_count',
            'options' => $aOptions,
            'required' => true,
        ];

        $aOptions = [];
        $d_id = 0;
        if (isset($aVals['district_id']) and $aVals['district_id'] != '' and $aVals['district_id'] != '0')
            $d_id = $aVals['district_id'];
        elseif(isset($aForms['district_id'])  and $aForms['district_id'] != '' and $aForms['district_id'] != '0')
            $d_id = $aForms['district_id'];
        if ($d_id != 0) {
            $district = AIN::sendApi('homdom_get_district', ['id' => $d_id]);
            if (isset($district['data']) and isset($district['data']['rows']) and count($district['data']['rows']) == 1) {
                $aOptions[$district['data']['rows'][0]['id']] = AIN::getPhrase('homdom.'.$district['data']['rows'][0]['phrase']);
            }
        }


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.district'),
            'value' => (isset($aVals['district_id']) ? $aVals['district_id'] : (isset($aForms['district_id']) ? $aForms['district_id'] : '11')),
            'type' => 'select',
            'id' => 'district_id',
            'class' => 'district_id',
            'id_css' => 'district_id',
            'options' => $aOptions,
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
