<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_complex_reviews_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->delete_reviews(['id' => $_GET['id']]);
        }
        $this->url()->send('complex.reviews.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
