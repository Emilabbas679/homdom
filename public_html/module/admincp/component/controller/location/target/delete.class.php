<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_location_target_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->homdom_delete_target(['id' => $_GET['id']]);
        }
        $this->url()->send('location.target.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
