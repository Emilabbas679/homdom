<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_contact extends AIN_Component
{

    public function process()
    {
        $meta['title'] = AIN::getPhrase('homdom.contact') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.contact_page_meta_description');
        $this->template()->assign(['meta'=> $meta]);


        $aVals = [];
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'full_name', 'required' => true, 'type' => 'string'],
                    ['field' => 'phone', 'required' => true, 'type' => 'string'],
                    ['field' => 'email', 'required' => true, 'type' => 'string'],
                    ['field' => 'content', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                $aVals['phone'] = str_replace('+', '', str_replace('(', '', str_replace(')', '', str_replace(' ','', str_replace('+', '',$aVals['phone'])))));

                $data = AIN::getService('homdom.core')->homdom_create_contact($aVals);

                if ('success' == $data['status']) {
                    $this->url()->send('contact',[], AIN::getPhrase('homdom.successfully_created'));
                } else {
                    AIN_ERROR::set(implode('<br/>', $data['messages']));
                }
            }
        }
        $this->template()->assign(['aForms' => $aVals]);

    }


}
