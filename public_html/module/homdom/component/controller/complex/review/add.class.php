<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_complex_review_add extends AIN_Component
{

    public function process()
    {

        if ($aVals = $this->request()->getArray('val')) {
            $validation = AIN::getService('homdom.helpers')->customValidator($aVals,
                [
                    ['field' => 'complex_id', 'required' => true, 'type' => 'string'],
                ]
            );

            if (count($validation) > 0) {
                foreach ($validation as $items) {
                    foreach ($items as $item) {
                        AIN_ERROR::set($item);
                    }
                }
            } else {
                if (auth())
                    $aVals['user_id'] = getUserBy('user_id');
                $aVals['status_id'] = 12;
                $aVals['entity_type'] = 1;
                $aVals['entity_id'] = $aVals['complex_id'];
                $data = AIN::getService('homdom.core')->create_reviews($aVals);
                if ('success' == $data['status']) {
                    $this->url()->send('complex-in/'.$aVals['complex_id'],[], AIN::getPhrase('homdom.review_created'));
                } else {
                    AIN_ERROR::set(implode('<br/>', $data['messages']));
                }
            }
        }

    }


}
