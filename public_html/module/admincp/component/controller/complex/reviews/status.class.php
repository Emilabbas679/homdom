<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_complex_reviews_status extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id']) and isset($_GET['status_id'])) {
            $data = AIN::getService('homdom.core')->status_reviews(['id' => $_GET['id'], 'status_id' => $_GET['status_id']]);
        }
        $this->url()->send('complex.reviews.index', [], AIN::getPhrase('homdom.successfully_updated'));
    }
}
