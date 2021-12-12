<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_profile_parameters extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'full_name', 'required' => true, 'type' => 'string'],
                    ['field' => 'phone', 'required' => true, 'type' => 'string'],
                ]
            );
            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            }
            else{
                $aVals['phone'] = str_replace('+', '', str_replace('(', '', str_replace(')', '', str_replace(' ','', str_replace('+', '',$aVals['phone'])))));
                if (isset($aVals['new_image']) and $aVals['new_image'] != '') {
                    $aVals['image'] = $aVals['new_image'];
                    unset($aVals['new_image']);
                }

                if (!isset($aVals['password']) or (isset($aVals['password']) and strlen($aVals['password']) < 5))
                    unset($aVals['password']);

                $aVals['language_id'] = getUserBy('language_id');
                $aVals['currency_id'] = getUserBy('currency_id');
                $aVals['user_group_id'] = getUserBy('user_group_id');
                $aVals['gender'] = getUserBy('gender');
                $aVals['user_id'] = getUserBy('user_id');
                $aVals['user_name'] = getUserBy('user_name');


                if ($data = AIN::sendApi('update_user', $aVals)) {
//                    var_dump($data); die();
                    if ('success' == $data['status']) {
                        $this->url()->send('profile.parameters', [], AIN::getPhrase('homdom.successfully_updated'));
                    } else {
                        AIN_ERROR::set(implode('<br/>', $data['messages']));
                    }
                }
            }
        }
    }


}
