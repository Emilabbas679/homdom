<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Agency_Add extends AIN_Component
{


    public function process()
    {
        $bIsEdit = false;
        $aForms = [];
        $aForms['id'] = 0;
        $aVals = [];

        if ($iEditId = $this->request()->getInt('id') and $iEditId != 0) {
            if ($aApi = AIN::getService('homdom.core')->homdom_get_agency(['id' => $iEditId])) {
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
                    ['field' => 'description', 'required' => true, 'type' => 'string'],
                    ['field' => 'email', 'required' => true, 'type' => 'string'],
                    ['field' => 'website', 'required' => true, 'type' => 'string'],
                    ['field' => 'phone', 'required' => true, 'type' => 'string'],
                    ['field' => 'address', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if ($aVals['old_image'] == '') {
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
                $aVals['work_days'] = json_encode($aVals['work_days']);
                $aVals['user_id'] = getUserBy('user_id');
                $aVals['slug'] = AIN::getService('homdom.helpers')->slugify($aVals['title']);
                if ($bIsEdit) {
                    $aVals['id'] = $iEditId;
                    if (($data = AIN::getService('homdom.core')->homdom_update_agency($aVals))) {
                        if ('success' == $data['status'])
                            $this->url()->send('agency.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_updated'));
                        else
                            AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                } else {

                    if ($data = AIN::getService('homdom.core')->homdom_create_agency($aVals)) {
                        if ('success' == $data['status']) {
                            $this->url()->send('agency.index', ['id' => $aForms['id']], AIN::getPhrase('homdom.successfully_created'));
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
        $aTableForm[$table]['title'] = AIN::getPhrase('homdom.agency_add');
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
            'title' => AIN::getPhrase('homdom.description'),
            'value' => (isset($aVals['description']) ? $aVals['description'] : (isset($aForms['description']) ? $aForms['description'] : '')),
            'type' => 'input:textarea',
            'id' => 'description',
            'class' => 'ckeditor',
            'required' => true,
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
            'value' => (isset($aVals['image']) ? $aVals['image'] : (isset($aForms['image']) ? $aForms['image'] : '')),
            'type' => 'input:hidden',
            'id' => 'old_image',
            'class' => 'old_image',
            'required' => true,
        ];


        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.email'),
            'value' => (isset($aVals['email']) ? $aVals['email'] : (isset($aForms['email']) ? $aForms['email'] : '')),
            'type' => 'input:text',
            'id' => 'email',
            'class' => 'email',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.website'),
            'value' => (isset($aVals['website']) ? $aVals['website'] : (isset($aForms['website']) ? $aForms['website'] : '')),
            'type' => 'input:text',
            'id' => 'website',
            'class' => 'website',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.phone'),
            'value' => (isset($aVals['phone']) ? $aVals['phone'] : (isset($aForms['phone']) ? $aForms['phone'] : '')),
            'type' => 'input:text',
            'id' => 'phone',
            'class' => 'phone',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.address'),
            'value' => (isset($aVals['address']) ? $aVals['address'] : (isset($aForms['address']) ? $aForms['address'] : '')),
            'type' => 'input:text',
            'id' => 'address',
            'class' => 'address',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.views'),
            'value' => (isset($aVals['views']) ? $aVals['views'] : (isset($aForms['views']) ? $aForms['views'] : 0)),
            'type' => 'input:number',
            'id' => 'views',
            'class' => 'views',
            'required' => true,
        ];




        $day_options = [];
        for ($i=1; $i<=7; $i++) {
            $day_options[$i] = AIN::getPhrase('homdom.weekday_'.$i);
        }
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.work_days'),
            'value' =>  (isset($aVals['work_days']) ? $aVals['work_days'] : (isset($aForms['work_days']) ? (array) json_decode($aForms['work_days']): [])),
            'type' => 'input:checkbox',
            'id' => 'work_days',
            'class' => 'work_days',
            'id_css' => 'work_days',
            'options' => $day_options,
            'required' => true,
        ];

        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.work_start_at'),
            'value' => (isset($aVals['work_start_at']) ? $aVals['work_start_at'] : (isset($aForms['work_start_at']) ? $aForms['work_start_at'] : 0)),
            'type' => 'input:time',
            'id' => 'work_start_at',
            'class' => 'work_start_at',
            'required' => true,
        ];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.work_end_at'),
            'value' => (isset($aVals['work_end_at']) ? $aVals['work_end_at'] : (isset($aForms['work_end_at']) ? $aForms['work_end_at'] : 0)),
            'type' => 'input:time',
            'id' => 'work_end_at',
            'class' => 'work_end_at',
            'required' => true,
        ];
        $aOptions = ['1' => AIN::getPhrase('homdom.agency_type_1')];
        $aTableForm[$table]['data'][] = [
            'title' => AIN::getPhrase('homdom.agency_type'),
            'value' => (isset($aVals['agency_type']) ? $aVals['agency_type'] : (isset($aForms['agency_type']) ? $aForms['agency_type'] : '1')),
            'type' => 'select',
            'id' => 'agency_type',
            'class' => 'agency_type',
            'id_css' => 'agency_type',
            'options' => $aOptions,
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
        $this->template()->assign(['aTableForm' => $aTableForm]);
        $this->template()->assign('aForms', $aForms);
        $this->template()->assign('bIsEdit', $bIsEdit);
    }
}
