<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_complex_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->homdom_delete_complex(['id' => $_GET['id']]);
        }
        $this->url()->send('complex.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
